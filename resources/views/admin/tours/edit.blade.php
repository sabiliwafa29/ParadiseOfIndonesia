@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Edit Tour</h2>
            @include('admin.tours._form', ['tour' => $tour, 'destinations' => $destinations])
        </div>
    </div>
</div>
@endsection
