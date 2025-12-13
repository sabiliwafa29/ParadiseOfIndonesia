<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpecialLink;
use App\Models\TourPackage;
use App\Models\Tour;
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
        $tours = Tour::orderBy('name_en')->get();
        return view('admin.special-links.create', compact('packages', 'tours'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tour_package_id' => 'required|exists:tour_packages,id',
            'tours' => 'nullable|array',
            'tours.*' => 'exists:tours,id',
            'price_special_idr' => 'nullable|numeric|min:0',
            'price_special_usd' => 'nullable|numeric|min:0',
            'price_special_cny' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
            'max_uses' => 'nullable|integer|min:1',
            'min_guests' => 'nullable|integer|min:1',
            'max_guests' => 'nullable|integer|min:1',
            'fixed_guests' => 'nullable|integer|min:1',
            'note' => 'nullable|string|max:1000',
        ]);
        // Ensure max_guests >= min_guests when both provided
        if (!empty($data['min_guests']) && !empty($data['max_guests']) && $data['max_guests'] < $data['min_guests']) {
            return redirect()->back()->withInput()->withErrors(['max_guests' => 'Max guests must be greater than or equal to min guests.']);
        }
        // If fixed_guests provided, set min/max to fixed for consistency
        if (!empty($data['fixed_guests'])) {
            $data['min_guests'] = $data['fixed_guests'];
            $data['max_guests'] = $data['fixed_guests'];
        }
        $data['token'] = Str::lower(Str::random(12));
        $data['created_by'] = auth()->id();

        $link = SpecialLink::create($data);

        // Save tours (array of ids) if provided
        if (!empty($data['tours'])) {
            $link->tours = array_values($data['tours']);
            $link->save();
        }

        return redirect()->route('admin.special-links.index')
            ->with('success', 'Special link created: ' . $link->token);
    }

    public function edit(SpecialLink $special_link)
    {
        // Order by the English name column (database column exists)
        $packages = TourPackage::orderBy('name_en')->get();
        $tours = Tour::orderBy('name_en')->get();
        return view('admin.special-links.edit', ['link' => $special_link, 'packages' => $packages, 'tours' => $tours]);
    }

    public function update(Request $request, SpecialLink $special_link)
    {
        $data = $request->validate([
            'tour_package_id' => 'required|exists:tour_packages,id',
            'tours' => 'nullable|array',
            'tours.*' => 'exists:tours,id',
            'price_special_idr' => 'nullable|numeric|min:0',
            'price_special_usd' => 'nullable|numeric|min:0',
            'price_special_cny' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
            'max_uses' => 'nullable|integer|min:1',
            'min_guests' => 'nullable|integer|min:1',
            'max_guests' => 'nullable|integer|min:1',
            'fixed_guests' => 'nullable|integer|min:1',
            'note' => 'nullable|string|max:1000',
        ]);

        if (!empty($data['min_guests']) && !empty($data['max_guests']) && $data['max_guests'] < $data['min_guests']) {
            return redirect()->back()->withInput()->withErrors(['max_guests' => 'Max guests must be greater than or equal to min guests.']);
        }

        // If fixed_guests provided, set min/max to fixed for consistency
        if (!empty($data['fixed_guests'])) {
            $data['min_guests'] = $data['fixed_guests'];
            $data['max_guests'] = $data['fixed_guests'];
        }

        $special_link->update($data);

        // update tours if provided (allow clearing)
        if (array_key_exists('tours', $data)) {
            $special_link->tours = $data['tours'] ?? [];
            $special_link->save();
        }

        return redirect()->route('admin.special-links.index')
            ->with('success', 'Special link updated');
    }

    public function destroy(SpecialLink $special_link)
    {
        $special_link->delete();
        return redirect()->route('admin.special-links.index')->with('success', 'Special link deleted');
    }
}
