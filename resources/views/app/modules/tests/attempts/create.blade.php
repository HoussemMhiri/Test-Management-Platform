@extends('layouts.app.base')

@section('right-content')
    <div id="tests-attempts">
        <tests-attempts />
    </div>
@endsection

@push('extra-scripts')
<script src="{{ mix('js/modules/tests/attempts/attempts.js') }}"></script>
@endpush
