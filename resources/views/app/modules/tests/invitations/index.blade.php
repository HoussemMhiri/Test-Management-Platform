@extends('layouts.app.base')

@section('right-content')
    <div id="tests-invitations">
        <tests-invitations />
    </div>
@endsection

@push('extra-scripts')
<script src="{{ mix('js/modules/tests/invitations/invitations.js') }}"></script>
@endpush
