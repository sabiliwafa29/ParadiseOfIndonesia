<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;
use App\Models\Tour;
use App\Models\TourPackage;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate {--output=public/sitemap.xml}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml from Tour and TourPackage models';

    /** @var Filesystem */
    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $output = $this->option('output') ?: 'public/sitemap.xml';

        $this->info("Generating sitemap to {$output}...");

        $domain = config('app.url') ?: env('APP_URL', 'http://localhost');
        $domain = rtrim($domain, '/');

        $urls = [];

        // Home page
        $urls[] = [
            'loc' => $domain . '/',
            'lastmod' => Carbon::now()->toAtomString(),
        ];

        // Tours - check if `is_published` column exists to avoid SQL errors on older schemas.
        $tourTable = (new Tour)->getTable();
        $tourQuery = Tour::query();
        if (Schema::hasColumn($tourTable, 'is_published')) {
            $tourQuery->where('is_published', true);
        } elseif (Schema::hasColumn($tourTable, 'published')) {
            $tourQuery->where('published', true);
        }
        $tourQuery->orderBy('updated_at', 'desc')->chunk(200, function ($tours) use (&$urls, $domain) {
            foreach ($tours as $tour) {
                $path = $tour->getUrlAttribute() ?? ("tours/{$tour->id}");
                $urls[] = [
                    'loc' => $domain . '/' . ltrim($path, '/'),
                    'lastmod' => optional($tour->updated_at)->toAtomString() ?: Carbon::now()->toAtomString(),
                ];
            }
        });

        // TourPackages - similar schema-safe check
        $pkgTable = (new TourPackage)->getTable();
        $pkgQuery = TourPackage::query();
        if (Schema::hasColumn($pkgTable, 'is_published')) {
            $pkgQuery->where('is_published', true);
        } elseif (Schema::hasColumn($pkgTable, 'published')) {
            $pkgQuery->where('published', true);
        }
        $pkgQuery->orderBy('updated_at', 'desc')->chunk(200, function ($packages) use (&$urls, $domain) {
            foreach ($packages as $pkg) {
                $path = $pkg->getUrlAttribute() ?? ("packages/{$pkg->id}");
                $urls[] = [
                    'loc' => $domain . '/' . ltrim($path, '/'),
                    'lastmod' => optional($pkg->updated_at)->toAtomString() ?: Carbon::now()->toAtomString(),
                ];
            }
        });

        // Build XML
        $xml = $this->buildXml($urls);

        $dir = dirname($output);
        if (! $this->files->exists($dir)) {
            $this->files->makeDirectory($dir, 0755, true);
        }

        $this->files->put($output, $xml);

        $this->info("Sitemap written to {$output} (urls: " . count($urls) . ")");

        return 0;
    }

    protected function buildXml(array $urls)
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $urlset = $dom->createElement('urlset');
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($urls as $u) {
            $url = $dom->createElement('url');

            $loc = $dom->createElement('loc', htmlspecialchars($u['loc']));
            $url->appendChild($loc);

            if (! empty($u['lastmod'])) {
                $lastmod = $dom->createElement('lastmod', $u['lastmod']);
                $url->appendChild($lastmod);
            }

            // Optional fields (changefreq, priority) may be added later by the user

            $urlset->appendChild($url);
        }

        $dom->appendChild($urlset);

        return $dom->saveXML();
    }
}
