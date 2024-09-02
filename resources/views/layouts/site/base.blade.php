@extends('layouts.master')

@section('screen-content')

    @if(!request()->routeIs('login-form'))
        @include('layouts.site.nav-bar')
    @endif

    @yield('full-content')

    <div class="ui grid">
        <div class="row">
            <div class="three wide column">
                @yield('left-aside')

            </div>

            <div class="ten wide column">
                @yield('content')
            </div>

            <div class="three wide column">
                @yield('right-aside')
            </div>
        </div>
    </div>

    @if(!request()->routeIs('login-form'))
        @include('layouts.site.footer')
    @endif
@endsection
