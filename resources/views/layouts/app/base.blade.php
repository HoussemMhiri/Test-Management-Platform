@extends('layouts.master')

@section('screen-content')
    @yield('full-content')

    <div class="ui grid" style="height:100vh;margin-top: 1px;">
        <div class="row stackable" style="height:100vh;">
            <div class="three wide column">
                @include('layouts.app.side')
                 @yield('left-content')
            </div>

            <div class="thirteen wide column">
                <div id="app-nav-bar">
                    <app-nav-bar />
                </div>
                <div style="min-height: 100vh; background-color:#f5f5f5; padding-left:10px !important; padding-right:20px !important">
                    @include('layouts.app.session-messages')
                    @yield('right-content')
                </div>

            </div>
        </div>
    </div>

@endsection

@push('extra-scripts')
    <script src="{{ mix('js/layouts/app/base.js') }}"></script>
@endpush
