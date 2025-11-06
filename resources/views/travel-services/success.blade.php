@extends('layouts.app')

@section('content')
<div class="py-12 flex justify-center">
    <div class="max-w-lg w-full bg-white p-6 rounded-lg shadow-md text-center">
        <h2 class="text-2xl font-bold text-emerald-700 mb-4">Payment Successful 🎉</h2>
        <p class="text-gray-700 mb-4">Your travel booking has been confirmed!</p>
        <a href="{{ route('travel-services.index') }}" class="bg-emerald-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-emerald-700 transition">
            Back to Travel Services
        </a>
    </div>
</div>
@endsection
