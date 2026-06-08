<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class AuditImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audit:images {--output=storage/logs/image-alt-audit.json}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan Blade views for <img> tags missing alt attributes and write a report';

    /** @var Filesystem */
    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $output = $this->option('output') ?: 'storage/logs/image-alt-audit.json';

        $this->info('Scanning resources/views for <img> tags without alt attribute...');

        $viewsPath = base_path('resources/views');
        $report = [
            'generated_at' => now()->toDateTimeString(),
            'missing_alt' => [],
            'summary' => [
                'files_scanned' => 0,
                'total_img_tags' => 0,
                'missing_alt_count' => 0,
            ],
        ];

        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($viewsPath));
        foreach ($iterator as $file) {
            if (! $file->isFile()) {
                continue;
            }
            if (! preg_match('/\.blade\.php$/', $file->getFilename())) {
                continue;
            }

            $report['summary']['files_scanned']++;
            $contents = $this->files->get($file->getPathname());

            // Find img tags
            if (preg_match_all('/<img\b[^>]*>/i', $contents, $matches, PREG_OFFSET_CAPTURE)) {
                $report['summary']['total_img_tags'] += count($matches[0]);

                foreach ($matches[0] as $match) {
                    $tag = $match[0];
                    // Check for alt attribute presence
                    if (! preg_match("/\\balt\\s*=\\s*(\"[^\"]*\"|'[^']*')/i", $tag)) {
                        $report['missing_alt'][] = [
                            'file' => str_replace(base_path() . DIRECTORY_SEPARATOR, '', $file->getPathname()),
                            'tag' => $tag,
                        ];
                        $report['summary']['missing_alt_count']++;
                    }
                }
            }
        }

        // Ensure directory exists
        $outDir = dirname($output);
        if (! $this->files->exists($outDir)) {
            $this->files->makeDirectory($outDir, 0755, true);
        }

        $this->files->put($output, json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        $this->info('Audit complete. Missing alt count: ' . $report['summary']['missing_alt_count']);
        $this->info('Report written to: ' . $output);

        return 0;
    }
}
