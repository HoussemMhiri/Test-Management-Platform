<link rel="stylesheet" href="{{asset('css/layouts/site/footer.css')}}"> 
<script src="{{asset('js/layouts/site/footer.js')}}"></script>
<footer>
    <div class="ui divider"></div>
    <div class="ui grid stackable">
        <div class="three wide column p-30">
            <div class="d-flex align-content-center justify-content-center">
{{--                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="logo">--}}
                <img src="https://studymock.com/assets/images/logo.svg" alt="{{ config('app.name') }}" class="logo">
            </div>

            <div class="slogan">
                @lang('site-footer.slogan')
            </div>

            <div class="d-flex align-content-center justify-content-center">
                <div><i class="envelope large icon primary-text-color"></i></div> <div class="email">contact@test-forge.com</div>
            </div>

            <div class="d-flex align-content-center justify-content-center mt-14">
                <i class="phone large icon primary-text-color"></i><span class="phone">(+216) 24 786 576</span>
            </div>

            <div class="social-icons primary-text-color">
                <i class="facebook large icon"></i>
                <i class="instagram large icon"></i>
                <i class="linkedin large icon"></i>
                <i class="twitter large icon"></i>
            </div>
        </div>

        <div class="three wide column p-30">
            <h2 class="ui header">@lang('site-footer.quick_links')</h2>

            <div class="footer-link">@lang('site-footer.demo')</div>
            <div class="footer-link">@lang('site-footer.about_us')</div>
            <div class="footer-link">@lang('site-footer.services')</div>
            <div class="footer-link">@lang('site-footer.pricing')</div>
            <div class="footer-link">@lang('site-footer.partners')</div>
            <div class="footer-link">@lang('site-footer.testimonials')</div>
            <div class="footer-link">@lang('site-footer.contact_us')</div>
        </div>

        <div class="three wide column p-30">
            <h2 class="ui header">@lang('site-footer.support')</h2>

            <div class="footer-link">@lang('site-footer.frequent_asked_questions')</div>
            <div class="footer-link">@lang('site-footer.claims')</div>
        </div>

        <div class="seven wide column p-30">
            <h2 class="ui header m-0">@lang('site-footer.newsletter')</h2>
            <h3 class="ui header mt-10">@lang('site-footer.subscribe_to_our_news_letter')</h3>
            <div class="ui form">
                <div class="field">
                    <div class="ui action input">
                        <input type="email" class="newsletter-input" placeholder="{{ trans('site-footer.enter_your_email_here') }}">
                        <button class="ui button send-btn">@lang('common.send')</button>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <div class="lower-footer primary-bg-color d-flex align-content-center justify-content-center">
        <p>© 2024 @lang('site-footer.powered_by', ['company' => "Cokitana"])</p>
    </div>
</footer>

