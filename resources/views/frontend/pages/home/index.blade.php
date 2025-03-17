@extends('frontend.layouts.master')
@section('content')
    @include('frontend.pages.home.sections.hero-section')
    <!-- Content Section -->
    <div class="relative -mt-32">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            @include('frontend.pages.home.sections.category-section')
            @include('frontend.pages.home.sections.cta-section')
        </div>
    </div>
@endsection
