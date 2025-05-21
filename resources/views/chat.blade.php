@extends('layouts.master')

@section('content')
    <div class="flex h-screen overflow-hidden">

        @include('partials.sidebar')

        @include('partials.mainchat')
    </div>
@endsection
