@extends('layouts.master')

@section('screen-content')

<div id="access-code">
    <access-code/>
 </div>

@endsection

@push('extra-scripts')
<script src="{{ mix('js/access_code/access-code.js') }}"></script>
@endpush