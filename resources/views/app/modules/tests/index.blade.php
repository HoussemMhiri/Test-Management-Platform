@extends('layouts.app.base')

@section('right-content')
    <div >
        <div id="tests-index">
            <tests-index/>
        </div>
    </div>
@endsection

@push('extra-scripts')
    <script src="{{ mix('js/modules/tests/index.js') }}"></script>
@endpush
