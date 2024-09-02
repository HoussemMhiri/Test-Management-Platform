<link rel="stylesheet" href="{{asset('css/layouts/site/about_us.css')}}">

<section class="about_container">  
<div class="ui two column grid stackable upper_about"> 
    <div class="row row_Cont"> 
<div class="eight  column about_left"> 
    <div class="img_logos">
 <img src="{{asset('images/site/about/about.jpg')}}" alt="{{config('app.name')}}" class="about_img"> 
 <div class="logos">
    <div class="logo1 d-flex align-items-center justify-content-center">
        <img src="{{asset('images/site/about/logo1.png')}}" alt="{{config('app.name')}}" class="logo1_img">
      
    </div>
  <div class="logo2 primary-bg-color">
    <p>@lang('about_us.logo')</p>
  </div>
 </div> 
</div> 
</div>

<div class="eight wide column about_right">
 <p class="first_p_about fw-600 primary-text-color">@lang('about_us.about_p')</p>
 <div class="about_desc fw-600">@lang('about_us.about_desc_one')
    <span class="primary-text-color">@lang('about_us.about_desc_two')</span></div>
    <p class="bf_button">@lang('about_us.bf_button').</p>
    <button >@lang('about_us.button')</button>
</div>
</div>
</div> 
<div class="ui three column grid stackable">
    <div class="row row_Cont">
      <div class="column col">
        <div class="upper_col d-flex align-items-center">
            <i class="laptop icon d-flex align-items-center justify-content-center"></i> 
            <span class="fw-600">@lang('about_us.mission')</span> 
        </div>
            <p>
                @lang('about_us.mission_desc').
            </p>
       
      </div>
      <div class="column col">
        <div class="upper_col  d-flex align-items-center">
            <i class="eye icon d-flex align-items-center justify-content-center"></i>
            <span class="fw-600">@lang('about_us.vision')</span> 
        </div>
            <p>@lang('about_us.vision_desc').</p>
      
      </div>
      <div class="column col">
        <div class="upper_col  d-flex align-items-center">
            <i class="chart line icon d-flex align-items-center justify-content-center"></i> 
            <span class="fw-600">@lang('about_us.values')</span> 
        </div>
            <p>@lang('about_us.values_desc').</p>
      </div>
    </div> 
</div> 
</section>