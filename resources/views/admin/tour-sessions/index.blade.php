@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Tour Sessions</h1>

    @if($sessions->count())
        <ul>
            @foreach($sessions as $s)
                <li class="mb-2">{{ $s->tour->name ?? 'Tour' }} - {{ $s->date }}</li>
            @endforeach
        </ul>
        <div class="mt-4">{{ $sessions->links() }}</div>
    @else
        <p>No sessions found.</p>
    @endif
</div>
@endsection
