@extends('layouts.app.base')

@section('right-content')

<div id="test-form">
    <test-form />
</div>

@endsection

@push('extra-scripts')
<script src="{{ mix('js/modules/tests/create.js') }}"></script>
@endpush
