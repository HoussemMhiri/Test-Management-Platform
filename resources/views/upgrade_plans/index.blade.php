@extends('layouts.master')

@section('screen-content')

<div id="upgrade_plans">
    <upgrade_plans/>
 </div>

@endsection

@push('extra-scripts')
<script src="{{ mix('js/upgrade_plans/upgrade_plans.js') }}"></script>
@endpush