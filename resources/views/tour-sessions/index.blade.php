@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <h2 class="text-2xl font-bold mb-6">Tour Sessions</h2>

                <div class="space-y-6">
                    @forelse ($sessions as $session)
                        <div class="bg-gray-100 rounded-lg shadow-md p-6">
                            <h3 class="text-xl font-semibold">{{ $session->name }}</h3>
                            <p class="text-gray-500">{{ $session->location }}</p>
                            <p class="text-gray-700 mt-2">{{ $session->description }}</p>
                            <div class="mt-4 text-sm">
                                <span class="font-medium">Date:</span>
                                <span>{{ \Carbon\Carbon::parse($session->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($session->end_date)->format('d M Y') }}</span>
                            </div>
                            @if($session->tourPackage)
                            <div class="mt-2 text-sm">
                                <span class="font-medium">Associated Package:</span>
                                <span>{{ $session->tourPackage->name }}</span>
                            </div>
                                @endif
                                <div class="mt-4">
                                    @if($session->tourPackage)
                                        <a href="{{ route('tour-packages.show', $session->tourPackage) }}" class="w-full py-2 bg-emerald-600 text-white rounded-md font-semibold text-center block hover:bg-emerald-700 transition">
                                            Book Now
                                        </a>
                                    @else
                                        <span class="w-full py-2 bg-gray-400 text-white rounded-md font-semibold text-center block cursor-not-allowed">
                                            No Package Available
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p>No tour sessions found.</p>
                        @endforelse
                </div>

                <div class="mt-6">
                    {{ $sessions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
