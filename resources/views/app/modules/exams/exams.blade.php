@extends('layouts.master')

@section('exam')

    <div id="exam-container">
        <exam-container />
    </div>

@endsection


@push('extra-scripts')
    <script src="{{ mix('js/modules/tests/exams/exams.js') }}"></script>
@endpush
