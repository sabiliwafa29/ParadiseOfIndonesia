<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpecialLink;
use App\Models\TourPackage;
use Illuminate\Support\Str;

class SpecialLinkController extends Controller
{
    public function index()
    {
        $links = SpecialLink::with('package')->orderBy('created_at', 'desc')->paginate(25);
        return view('admin.special-links.index', compact('links'));
    }

    public function create()
    {
        // Order by the English name column (database column exists)
        $packages = TourPackage::orderBy('name_en')->get();
        return view('admin.special-links.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tour_package_id' => 'required|exists:tour_packages,id',
            'price_special_idr' => 'nullable|numeric|min:0',
            'price_special_usd' => 'nullable|numeric|min:0',
            'price_special_cny' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
            'max_uses' => 'nullable|integer|min:1',
            'note' => 'nullable|string|max:1000',
        ]);

        $data['token'] = Str::lower(Str::random(12));
        $data['created_by'] = auth()->id();

        $link = SpecialLink::create($data);

        return redirect()->route('admin.special-links.index')
            ->with('success', 'Special link created: ' . $link->token);
    }

    public function edit(SpecialLink $special_link)
    {
        // Order by the English name column (database column exists)
        $packages = TourPackage::orderBy('name_en')->get();
        return view('admin.special-links.edit', ['link' => $special_link, 'packages' => $packages]);
    }

    public function update(Request $request, SpecialLink $special_link)
    {
        $data = $request->validate([
            'tour_package_id' => 'required|exists:tour_packages,id',
            'price_special_idr' => 'nullable|numeric|min:0',
            'price_special_usd' => 'nullable|numeric|min:0',
            'price_special_cny' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
            'max_uses' => 'nullable|integer|min:1',
            'note' => 'nullable|string|max:1000',
        ]);

        $special_link->update($data);

        return redirect()->route('admin.special-links.index')
            ->with('success', 'Special link updated');
    }

    public function destroy(SpecialLink $special_link)
    {
        $special_link->delete();
        return redirect()->route('admin.special-links.index')->with('success', 'Special link deleted');
    }
}
