@extends('layouts.app.base')

@section('right-content')
    <div id="tests-session">
        <tests-session-index />
    </div>
@endsection

@push('extra-scripts')
<script src="{{ mix('js/modules/tests/sessions/session.js') }}"></script>
@endpush
