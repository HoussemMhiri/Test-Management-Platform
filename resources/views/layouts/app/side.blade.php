<div class="sidebar-menu">
    <link rel="stylesheet" href="{{ asset('css/layouts/app/side.css') }}">

        <div class="logo_newTest">
            <div class="logo-container">
                <img src="https://studymock.com/assets/images/logo.svg" alt="Logo" class="image logo">
            </div>

            <div class="premium-btn-container">
                <i class="fas fa-plus fa-plus"></i>
                <a href="{{ route('tests.create') }}">@lang('app-side.create_new_test')</a>
            </div>
        </div>

        <a class="ui celled list side-menu">
            <a href="{{ route('tests.index') }}" class="item {{ request()->is('tests', 'tests.fetch', 'tests.show') ? 'active-menu-item' : '' }} menu-item">
                <i class="fa-solid icon fa-newspaper"></i>
                <span class="list-item">@lang('app-side.list_of_tests')</span>
            </a>

            <a href="{{ route('tests.attempts.index') }}" class="item {{ request()->routeIs('tests.attempts.index') ? 'active-menu-item' : '' }} menu-item">
                <i class="fa-solid icon fa-book-open"></i>
                <span class="list-item">@lang('app-side.tests_attempts')</span>
            </a>

            <a href="{{ route('tests.invitations.index') }}" class="item {{ request()->routeIs('tests.invitations.index') ? 'active-menu-item' : '' }} menu-item">
                <i class="fa-solid icon fa-envelope-open"></i>
                <span class="list-item">@lang('app-side.tests_invitations')</span>
            </a>
            <a href="{{ route('testsSession.index') }}" class="item {{ request()->routeIs('testsSession.index') ? 'active-menu-item' : '' }} menu-item">
            <i class="clipboard icon"></i>
                <span  class="list-item">@lang('app-side.tests_session')</span>
 
            @if (auth()->check() && auth()->user()->is_admin)
           <a href="{{ route('subscription_plans.index') }}" class="item {{ request()->routeIs('subscription_plans.index') ? 'active-menu-item' : '' }} menu-item">
                <i class="list ol icon"></i>
                <span  class="list-item">@lang('app-side.plans')</span>
            </a>
        @endif
    </a>
        </div>

