@extends('layouts.master')

@section('exam')

    <div id="exam-access">
        <exam-access />
    </div>

@endsection


@push('extra-scripts')
    <script src="{{ mix('js/modules/tests/exams/access.js') }}"></script>
@endpush
