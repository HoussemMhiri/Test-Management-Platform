@extends('layouts.master')

@section('screen-content')

<div id="accept_invitation">
    <accept_invitation/>
 </div>

@endsection

@push('extra-scripts')
<script src="{{ mix('js/accept_invitation/accept_invitation.js') }}"></script>
@endpush