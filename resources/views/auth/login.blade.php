@extends('layouts.site.base')
@php
    use App\Enums\GenderEnum;
@endphp

@section('extra-styles')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}" />
@endsection

@section('full-content')
    <div class="container {{ session('login-view') === 'register' ? 'active' : '' }}" id="container">
        <div class="form-container sign-up">
            <form method="POST" action="{{ route('register') }}" class="ui form">
                @csrf
                <h1>@lang('auth.create_account')</h1>
                <div class="social-icons">
                    <a href="#" class="icons">
                        <i class="fa-brands fa-google-plus-g"></i>
                    </a>
                    <a href="#" class="icons">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#" class="icons">
                        <i class="fa-brands fa-github"></i>
                    </a>
                    <a href="#" class="icons">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </div>

               <div class="equal width fields">
                   <div class="field {{ $errors->has('username') ? ' error' : '' }}">
                       <input type="text" name="username" placeholder="Username" value="{{ old('username') }}">

                       {!! renderInlineError('username') !!}
                   </div>

                   <div class="field {{ $errors->has('email') ? ' error' : '' }}">
                       <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">

                       {!! renderInlineError('email') !!}
                   </div>
               </div>

                <div class="fields">
                    <div class="sixteen wide field {{ $errors->has('password') ? ' error' : '' }}">
                        <input type="password" name="password" placeholder="Password" value="{{ old('password') }}">

                        {!! renderInlineError('password') !!}
                    </div>

                    <div class="sixteen wide field {{ $errors->has('password_confirmation') ? ' error' : '' }}">
                        <input type="password" name="password_confirmation" placeholder="Password Confirmation" value="{{ old('password_confirmation') }}">

                        {!! renderInlineError('password_confirmation') !!}
                    </div>
                </div>

                <div class="equal width fields">

                    <div class="sixteen wide field {{ $errors->has('first_name') ? ' error' : '' }}">
                        <input type="text" name="first_name" placeholder="First name" value="{{ old('first_name') }}">

                        {!! renderInlineError('first_name') !!}
                    </div>

                    <div class="sixteen wide field {{ $errors->has('last_name') ? ' error' : '' }}">
                        <input type="text" name="last_name" placeholder="Last name" value="{{ old('last_name') }}">

                        {!! renderInlineError('last_name') !!}
                    </div>
                </div>

                <div class="fields">
                    <div class="sixteen wide field {{ $errors->has('phone') ? ' error' : '' }}">
                        <input type="text" name="phone" placeholder="Phone" value="{{ old('phone') }}">

                        {!! renderInlineError('phone') !!}
                    </div>
                </div>

                <div class="fields">
                    <div class="sixteen wide field {{ $errors->has('city') ? ' error' : '' }}">
                        <input type="text" name="city" placeholder="City" value="{{ old('city') }}">

                        {!! renderInlineError('city') !!}
                    </div>

                    <div class="sixteen wide field {{ $errors->has('country') ? ' error' : '' }}">
                        <input type="text" name="country" placeholder="Country" value="{{ old('country') }}">

                        {!! renderInlineError('country') !!}
                    </div>
                </div>

                <div class="fields">
                    <div class="sixteen wide field {{ $errors->has('address') ? ' error' : '' }}">
                        <input type="text" name="address" placeholder="Address" value="{{ old('address') }}">

                        {!! renderInlineError('address') !!}
                    </div>
                </div>

                <div class="fields">
                    <div class="sixteen wide field {{ $errors->has('postal_code') ? ' error' : '' }}">
                        <input type="text" name="postal_code" placeholder="Postal code" value="{{ old('postal_code') }}">

                        {!! renderInlineError('postal_code') !!}
                    </div>

                    <div class="sixteen wide field {{ $errors->has('governorate') ? ' error' : '' }}">
                        <input type="text" name="governorate" placeholder="Governorate" value="{{ old('governorate') }}">

                        {!! renderInlineError('governorate') !!}
                    </div>
                </div>

                <div class="radion-gender">
                    <div class="radio-container">
                        @foreach (GenderEnum::values() as $gender)
                            <label class="radio-label">
                                <input type="radio" name="gender" value="{{ $gender }}" class="custom-radio">
                                <span class="radio-circle"></span>
                                {{ __($gender) }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <button type="submit">@lang('auth.sign_up')</button>
            </form>
        </div>


        <div class="form-container sign-in">
            <form method="POST" action="{{ route('login') }}" class="ui form">
                @csrf
                <h1>@lang('auth.sign_in')</h1>
                <div class="social-icons">
                    <a href="#" class="icons">
                        <i class="fa-brands fa-google-plus-g"></i>
                    </a>
                    <a href="#" class="icons">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#" class="icons">
                        <i class="fa-brands fa-github"></i>
                    </a>
                    <a href="#" class="icons">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </div>

                <div class="sixteen wide field {{ $errors->has('email') ? ' error' : '' }}">
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">

                    {!! renderInlineError('email') !!}
                </div>

                <div class="sixteen wide field {{ $errors->has('password') ? ' error' : '' }}">
                    <input type="password" name="password" placeholder="Password">

                    {!! renderInlineError('password') !!}
                </div>

                <a href="">@lang('auth.forgot_password')</a>

                <button type="submit">@lang('auth.sign_in')</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>@lang('auth.welcome_back')</h1>
                    <p>@lang('auth.enter_personal_details_to_login')</p>
                    <button class="hidden" id="sign-in-btn">@lang('auth.sign_in')</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>@lang('auth.hello_friend')</h1>
                    <p>@lang('auth.enter_personal_details_to_sign_up')</p>
                    <button class="hidden" id="register-btn">@lang('auth.sign_up')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('extra-scripts')
    <script src="{{ mix('js/auth/login.js') }}"></script>
@endpush
