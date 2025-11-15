@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Tour Activities</h1>

    @if($activities->count())
        <ul>
            @foreach($activities as $a)
                <li class="mb-2">{{ $a->name }}</li>
            @endforeach
        </ul>
        <div class="mt-4">{{ $activities->links() }}</div>
    @else
        <p>No activities found.</p>
    @endif
</div>
@endsection
