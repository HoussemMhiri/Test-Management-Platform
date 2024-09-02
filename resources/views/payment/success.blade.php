@extends('layouts.master')

@section('screen-content')

<div id="success">
    <success/>
 </div>

@endsection

@push('extra-scripts')
<script src="{{ mix('js/payment/success.js') }}"></script>
@endpush