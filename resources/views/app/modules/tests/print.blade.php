<div class="exam_print">
    <div class="ui container exam-content">
        <div class="ui relaxed divided list">
            @foreach ($questions as $index => $question)
                @if ($question['type'] !== App\Enums\QuestionTypeEnum::ATTACHMENT)
                    <div class="item exam-question">
                        <div class="content">
                            <h3 class="header">{{ $index + 1 }}. {{ $question['text'] }}</h3>
                            <div class="description">
                                @if ($question['type'] === App\Enums\QuestionTypeEnum::TEXT)
                                    <div class="field">
                                        <textarea name="question{{ $index }}" rows="4"></textarea>
                                    </div>
                                @elseif ($question['type'] === App\Enums\QuestionTypeEnum::CHOICES_SELECTION)
                                    @foreach ($question['answers'] as $answer)
                                        <div class="field exam-answer">
                                            <div class="ui radio checkbox">
                                                <input type="radio" name="question{{ $index }}"
                                                    value="{{ $answer['text'] }}">
                                                <label>{{ $answer['text'] }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                @elseif ($question['type'] === App\Enums\QuestionTypeEnum::CHOICES_ORDERING)
                                    @foreach ($question['answers'] as $answer)
                                        <div class="field exam-answer">
                                            <div class="ten wide field">
                                                <input class="order_input" type="number"
                                                    name="question{{ $index }}" value="{{ $answer['text'] }}">
                                                <label>{{ $answer['text'] }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>


<style>
    .exam_print {
        background-image: url('{{ $report_background_image }}');
        background-size: contain;

        background-repeat: no-repeat;
        padding-top: {{ $report_margin_top }}px;
        padding-bottom: {{ $report_margin_buttom }}px;
        padding-left: {{ $report_margin_left }}px;
        padding-right: {{ $report_margin_right }}px;
    }

    .exam_print {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        font-family: 'Arial', sans-serif;
        background-color: #f5f5f5;
        color: #333;
    }

    .exam-header {
        text-align: center;
        margin-bottom: 2em;
        padding: 1em;
        background-color: #fff;
    }

    .exam-header h1 {
        margin-bottom: 0.5em;
    }

    .exam-header p {
        margin: 0.2em 0;
    }

    .exam-content {
        flex: 1;
        margin: 0 2em;
        padding: 1em;
        background-color: #fff;
    }

    .exam-question {
        margin-bottom: 1.5em;
    }

    .exam-question h3 {
        margin-bottom: 0.5em;
    }

    .exam-answer {
        margin-bottom: 0.5em;
    }

    .exam-footer {
        text-align: center;
        margin-top: 2em;
        padding: 1em 0;
        background-color: #f9f9f9;
    }

    .exam-footer p {
        margin: 0.5em 0;
    }

    .ui.radio.checkbox label {
        font-size: 1em;
        margin-left: 0.5em;
    }

    .order_input {
        width: 40px;
        height: 35px;
    }

    .exam-content .field textarea {
        width: 100%;
    }
</style>
