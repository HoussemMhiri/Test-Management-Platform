@extends('layouts.app.base')

@section('right-content')

<div id="subscription_plans">
   <subscription_plans/>
 </div>

@endsection

@push('extra-scripts')
<script src="{{ mix('js/subscription_plans/subscription_plans.js') }}"></script>
@endpush