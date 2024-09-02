<link rel="stylesheet" href="{{ asset('css/layouts/site/pricing.css') }}">
@php
    use App\Enums\PlanLimitationTypeEnum;
@endphp

<div class="selection">
    <h1>@lang('price.select') <span class="highlight">@lang('price.pricing')</span> @lang('price.plans')</h1>
</div>


<div class="courses-wrapper-02">
    <div class="ui stackable equal width grid">
        @foreach($subscriptionPlans as $plan)
        <div class="column">
            <div class="single-courses widget-information">
                <div class="courses-content pt-0">
                    <h6></h6>
                 
                    <div class="courses-author">
                        <h1 class="pricing-title">{{$plan->name}}</h1>
                        <div class="tag">
                            <p><strong>{{ $plan->monthly_price == floor($plan->monthly_price) ? number_format($plan->monthly_price, 0) : number_format($plan->monthly_price, 2) }}$</strong></p>
                            <a href="javascript:;">@lang('price.month')</a>
                        </div>
                    </div>

                    <h4 class="title"><a href="javascript:;">{{$plan->description}}</a></h4>
                    <div class="info-list">
                        <ul>
                            @foreach(explode(',', $plan->features) as $feature)
                                            <li><strong>@lang('price.features')</strong> <span>{{ $feature}}</span></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="info-list">
                        <ul>
                           
                        <li><strong>@lang('price.annual'):</strong> <span>{{ $plan->annual_price == floor($plan->annual_price) ? number_format($plan->annual_price, 0) : number_format($plan->annual_price, 2) }}$</span></li>
                        <li><strong>@lang('price.individual'):</strong> <span>{{ $plan->individual_template_price == floor($plan->individual_template_price) ? number_format($plan->individual_template_price, 0) : number_format($plan->individual_template_price, 2) }}$</span></li>
                        <li><strong>@lang('price.type'):</strong> <span>{{ $plan->plan_limitation_type}}</span></li>
                        @if ($plan->plan_limitation_type->value === PlanLimitationTypeEnum::NUMBER->value)
                        <li><strong>@lang('price.max'):</strong> <span>{{ $plan->max_templates_number }}</span></li>
                    @endif
                       
                       
                        </ul>
                    </div>
                    <div class="all_btns">
                        <div class="courses-btn courses-btn2 text-center ">
                            <a href="#" class="w-100 btn btn-primary btn-hover-dark ">@lang('price.started')</a>
                        </div>
                    </div>
                 
                </div>
            </div>
        </div>
        @endforeach
      
    </div>
</div>


