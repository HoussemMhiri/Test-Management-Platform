<link rel="stylesheet" href="{{asset('css/layouts/site/nav-bar.css')}}">
<script src="{{asset('js/layouts/site/nav-bar.js')}}"></script>

<nav>
  <div class="ui grid stackable upper_navCont">
    <div class="six wide column p-0 d-flex justify-content-center align-items-center slogan">
        @lang('site-nav.slogan') <span class="primary-text-color ml-5 fw-600">@lang('site-nav.for_free')</span>
    </div>
    <div class="four wide column p-0 d-flex justify-content-center align-items-center mail">contact@test-forge.com</div>
    <div class="six wide column p-0 d-flex justify-content-center align-items-center">
      <select name="" id="" class="selection">
        <option value="" disabled selected>EN</option>
        <option value="english">@lang('site-nav.english')</option>
        <option value="french">@lang('site-nav.french')</option>
      </select>
    </div>
  </div>

  <div class="ui grid stackable bottom_nav">
    <div class="four wide column imgCont">
{{--      <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="img">--}}
      <img src="https://studymock.com/assets/images/logo.svg" alt="{{ config('app.name') }}" class="img">
    </div>
    <div class="eight wide column menu">
      <div class="menu-items">
          <p>@lang('site-nav.home')</p>
          <p>@lang('site-nav.about us')</p>
          <p>@lang('site-nav.services')</p>
          <p class="contact">@lang('site-nav.contact')</p>
      </div>
    </div>
    <div class="four wide column login">
      <a href="{{ route('login-form') }}" class="signIn">@lang('site-nav.login')</a>
      <a href="{{ route('login-form') }}" class="register">@lang('site-nav.sign up')</a>
    </div>
  </div>
</nav> 


<a href="#" class="btn_scroll" >
  <i class="angle up icon"></i>
</a> 

