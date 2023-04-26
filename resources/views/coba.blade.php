@extends('layouts.main')
@section('content')
    <div class="mt-2">
        <ul class="p-1">
            @if(auth()->user()->role === 'admin')

            @endif
        </ul>
    </div>
@endsection
