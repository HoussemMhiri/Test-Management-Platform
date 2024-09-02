@extends('layouts.site.base')

@section('full-content')
    @include('layouts.site.hero')
@endsection

@section('content')
    @include('layouts.site.about_us')
    @include('layouts.site.features')
    @include('layouts.site.pricing')
    @include('layouts.site.testimonials')
    @include('layouts.site.became-member')
@endsection
