<link rel="stylesheet" href="{{ asset('css/layouts/app/session-messages.css') }}">

{{-- @if(session()->has('messages'))
    @foreach(session('messages') as $message) --}}
        <div class="message_container">
            <div class="message">
            <i class="exclamation circle icon"></i> You still have only 1 free test left in your free tiral. <a href="{{route('upgrade_plans.index')}}" style="color: black"><span>Upgrade your plan here</span></a>  {{-- {{ $message}} --}}
        </div>
        </div>
{{--     @endforeach
@endif --}}

