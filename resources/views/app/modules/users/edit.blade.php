@extends('layouts.app.base')

@section('right-content')
    <div id="users-form">
       <users-form/>
    </div>
@endsection

@push('extra-scripts')
<script src="{{ mix('js/modules/users/edit.js') }}"></script>
@endpush
