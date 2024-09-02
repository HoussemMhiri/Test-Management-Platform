
<link rel="stylesheet" href="{{asset('css/layouts/site/hero.css')}}">

<div class="ui grid stackable Hero_Section">
    <div class="column Hero_Section_Content">
        <div class="ui equal width stackable grid">

            <div class="seven wide column left_Hero">
               <div class="left_Hero_Content">
                   <p class="first_p fw-600 primary-text-color">@lang('hero.slogan')</p>
                   <div class="hero_desc fw-600">
                       @lang('hero.description')

                       <p>@lang('hero.descP')<span class="primary-text-color"> @lang('hero.span')</span></p>
                   </div>
                   <div class="hero_button_cont">
                       <p>@lang('hero.buttonP')</p>
                       <button>@lang('hero.button')</button>
                   </div>
               </div>
            </div>

            <div class="nine wide column right_hero">
                <img
                    src="{{asset('images/site/hero/Hero.png')}}"
                    class="hero_img"
                    alt="{{config('app.name')}}"
                />
            </div>

        </div>
    </div>
  </div>




