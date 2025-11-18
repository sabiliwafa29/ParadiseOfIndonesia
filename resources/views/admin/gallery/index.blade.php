@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Gallery</h1>

    @if($galleries->count())
        <div class="grid grid-cols-3 gap-4">
            @foreach($galleries as $g)
                <div class="border p-2">
                    @include('components.responsive-image', [
                        'path' => $g->image,
                        'alt' => $g->title ?? '',
                        'class' => 'w-full h-48 object-cover',
                        'derivatives' => $g->image_derivatives,
                    ])
                    <p class="mt-2">{{ $g->title }}</p>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $galleries->links() }}</div>
    @else
        <p>No images yet.</p>
    @endif
</div>
@endsection
