@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Travel Services</h1>

    @if($services->count())
        <ul>
            @foreach($services as $service)
                <li class="mb-2">{{ $service->name }} - {{ $service->base_price }}</li>
            @endforeach
        </ul>
        <div class="mt-4">{{ $services->links() }}</div>
    @else
        <p>No services found.</p>
    @endif
</div>
@endsection
