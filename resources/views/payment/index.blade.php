@extends('layouts.master')

@section('screen-content')

<div id="payment">
    <payment/>
 </div>

@endsection

@push('extra-scripts')
<script src="{{ mix('js/payment/payment.js') }}"></script>
@endpush