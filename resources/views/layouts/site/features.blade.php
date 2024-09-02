<link rel="stylesheet" href="{{asset('css/layouts/site/features.css')}}"> 

<section class="features_container"> 
    <div class="titles">
    <h3 class="primary-text-color">@lang('features.h3').</h3>
    <h1>@lang('features.h1') <span class="primary-text-color">Test Forge</span></h1> 
</div> 
<div class="ui six column grid ">
    <div class="row stackable row_Cont_F">
      <div class="column colu">
        <div class="icons_logo">
            <i class="search icon"></i> 
            <img src="{{asset('images/site/features/shape_1.png')}}" alt="{{config('app.name')}}" class="shape_img">
        </div>
        <h2>@lang('features.title_one')</h2>
        <p>@lang('features.p_one').</p>
      </div> 
      <div class="arrow_cont">
      <img src="{{asset('images/site/features/arrow.png')}}" alt="{{config('app.name')}}"  class="arrow_img">
    </div> 
      <div class="column colu">
        <div class="icons_logo">
            <i class="search icon"></i> 
            <img src="{{asset('images/site/features/shape_1.png')}}" alt="{{config('app.name')}}" class="shape_img"> 
        </div>
        <h2>@lang('features.title_two')</h2>
        <p>@lang('features.p_two').</p>
      </div>  
      <div class="arrow_cont">
        <img src="{{asset('images/site/features/arrow.png')}}" alt="{{config('app.name')}}"  class="arrow_img">
      </div> 
      <div class="column colu">
        <div class="icons_logo">
            <i class="search icon"></i> 
            <img src="{{asset('images/site/features/shape_1.png')}}" alt="{{config('app.name')}}" class="shape_img"> 
        </div>
        <h2>@lang('features.title_three')</h2>
        <p>@lang('features.p_three').</p>
      </div>  
     
    </div>
    <div class="row stackable row_Cont_F">
        <div class="column colu">
            <div class="icons_logo">
                <i class="search icon"></i> 
                <img src="{{asset('images/site/features/shape_1.png')}}" alt="{{config('app.name')}}" class="shape_img">
            </div>
            <h2>@lang('features.title_four')</h2>
            <p>@lang('features.p_four').</p>
          </div>  
          <div class="arrow_cont">
            <img src="{{asset('images/site/features/arrow.png')}}" alt="{{config('app.name')}}"  class="arrow_img">
          </div> 
          <div class=" column colu">
            <div class="icons_logo">
                <i class="search icon"></i> 
                <img src="{{asset('images/site/features/shape_1.png')}}" alt="{{config('app.name')}}" class="shape_img">
            </div>
            <h2>@lang('features.title_five')</h2>
            <p>@lang('features.p_five').</p>
          </div> 
          <div class="arrow_cont">
            <img src="{{asset('images/site/features/arrow.png')}}" alt="{{config('app.name')}}"  class="arrow_img">
          </div> 
          <div class="column colu">
            <div class="icons_logo">
                <i class="search icon"></i> 
                <img src="{{asset('images/site/features/shape_1.png')}}" alt="{{config('app.name')}}" class="shape_img">
            </div>
            <h2>@lang('features.title_six')</h2>
            <p>@lang('features.p_six').</p>
          </div> 
    </div>
    </div>
</section>