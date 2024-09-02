<template>
    <div>
        <div class="ui form">
            <div class="field arrow_up_down">
                <i class="arrow down icon" @click="moveDown"
                    :style="{ visibility: index !== questionCount - 1 ? 'visible' : 'hidden' }"></i>
                <i class="arrow up icon" @click="moveUp"
                    :style="{ visibility: index !== 0 ? 'visible' : 'hidden' }"></i>
            </div>
            <div class="inline fields">
                <div class="three wide field">
                    <label>{{ trans("questions.add_description") }}</label>
                </div>
                <div class="thirteen wide field">
                    <div class="ui radio checkbox">
                        <input v-model="question.text" type="radio" :name="'text-' + index" value="1">
                        <label>{{ trans("common.yes") }}</label>
                    </div>
                    <div class="ui radio checkbox">
                        <input v-model="question.text" type="radio" :name="'text-' + index" value="0">
                        <label>{{ trans("common.no") }}</label>
                    </div>
                </div>
            </div>

            <div class="field" v-if="question.text === '1'">
                <textarea v-model="question.description" class="text-input"></textarea>
            </div>

            <div class="inline fields">
                <div class="four wide field">
                    <label>{{ trans("questions.add_media") }}</label>
                </div>
                <div class="twelve wide field">
                    <div class="ui radio checkbox">
                        <input v-model="question.media_link_check" type="radio" :name="'media_link-' + index" value="1">
                        <label>{{ trans("common.yes") }}</label>
                    </div>
                    <div class="ui radio checkbox">
                        <input v-model="question.media_link_check" type="radio" :name="'media_link-' + index" value="0">
                        <label>{{ trans("common.no") }}</label>
                    </div>
                </div>
            </div>

            <div class="field" v-if="question.media_link_check === '1'">
                <input v-model="question.media_link" placeholder="https://example.com" type="url" class="media">
            </div>

            <div class="inline fields">
                <div class="four wide field">
                    <label>{{ trans("questions.add_duration") }}</label>
                </div>
                <div class="seven wide field">
                    <div class="ui radio checkbox">
                        <input v-model="question.duration_enabled" type="radio" :name="'duration_enabled-' + index"
                            value="1">
                        <label>{{ trans("common.yes") }}</label>
                    </div>
                    <div class="ui radio checkbox">
                        <input v-model="question.duration_enabled" type="radio" :name="'duration_enabled-' + index"
                            value="0">
                        <label>{{ trans("common.no") }}</label>
                    </div>
                    <div class="five wide field" v-if="question.duration_enabled === '1'">
                        <input v-model="question.duration" type="number" name="duration" class="duration">
                    </div>
                </div>
            </div>

            <div class="inline fields">
                <div class="three wide field">
                    <label>{{ trans("questions.evaluation_manuelle") }}</label>
                </div>
                <div class="thirteen wide field">
                    <div class="ui radio checkbox">
                        <input v-model="question.require_manual_evaluation" type="radio"
                            :name="'require_manual_evaluation-' + index" value="1">
                        <label>{{ trans("common.yes") }}</label>
                    </div>
                    <div class="ui radio checkbox">
                        <input v-model="question.require_manual_evaluation" type="radio"
                            :name="'require_manual_evaluation-' + index" value="0">
                        <label>{{ trans("common.no") }}</label>
                    </div>
                </div>
            </div>

            <div class="inline fields">
                <div class="three wide field">
                    <label>{{ trans("questions.type_evaluation") }}</label>
                </div>
                <div class="thirteen wide field">
                    <div class="ui radio checkbox" v-for="(evaluation, idx) in enumValues.EvaluationEnum" :key="idx">
                        <input v-model="question.evaluation_type" type="radio" :name="'evaluation_type-' + index + '-' + idx"
                            :value="evaluation.code">
                        <label>{{ evaluation.name }}</label>
                    </div>
                </div>
            </div>

            <div class="inline fields">
                <label class="type_question">{{ trans("questions.type_question") }}</label>
                <div class="field">
                    <div class="ui radio checkbox spaced-radio"
                        v-for="(questionType, idx) in enumValues.QuestionTypeEnum" :key="idx">
                        <input v-model="question.type" type="radio" :name="'type-' + index + '-' + idx" :value="questionType.code">
                        <label>{{ questionType.name }}</label>
                    </div>
                </div>
            </div>

            <div class="three fields">
                <div class="field" v-if="question.type === 'Choices Selection' || question.type === 'Choices Ordering'">
                    <label>{{ trans("questions.bonus_1st_place") }}</label>
                    <input v-model="question.first_place_bonus" type="number" placeholder="Bonus 1st place"
                        class="bonus_input">
                </div>
                <div class="field" v-if="question.type === 'Choices Selection' || question.type === 'Choices Ordering'">
                    <label>{{ trans("questions.bonus_2nd_place") }}</label>
                    <input v-model="question.second_place_bonus" type="number" placeholder="Bonus 2nd place"
                        class="bonus_input">
                </div>
                <div class="field" v-if="question.type === 'Choices Selection' || question.type === 'Choices Ordering'">
                    <label>{{ trans("questions.bonus_3rd_place") }}</label>
                    <input v-model="question.third_place_bonus" type="number" placeholder="Bonus 3rd place"
                        class="bonus_input">
                </div>
            </div>

            <button @click="addAnswer" class="add_answer">
                <i class="plus icon"></i>
                {{ trans("answers.add_answer") }}
            </button>

            <div v-if="question.type === 'Choices Selection'">
                <table class="ui celled table">
                    <thead>
                        <tr>
                            <th class="one wide">{{ trans("questions.correct") }}</th>
                            <th class="eleven wide">{{ trans("questions.answer_text") }}</th>
                            <th class="two wide">{{ trans("questions.points") }}</th>
                            <th class="two wide">{{ trans("questions.actions") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <ChoiceSelection v-for="(answer, idx) in question.answers" :key="idx"
                            :model-answer-value="answer" :index="idx" :answer-count="question.answers.length"
                            @update:modelAnswerValue="updateAnswer($event, idx)" @move-up="moveAnswerUp(idx)"
                            @move-down="moveAnswerDown(idx)" @delete="deleteAnswer(idx)" :answer="answer" />
                        <tr v-if="showAddQuestionMessageSelection">
                            <td colspan="4">
                                <span class="ui message">
                                    {{ trans("questions.press_add_answer") }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <div v-if="question.type === 'Choices Ordering'">
                <table class="ui celled table">
                    <thead>
                        <tr>
                            <th class="one wide">{{ trans("questions.order") }}</th>
                            <th class="eleven wide">{{ trans("questions.answer_text") }}</th>
                            <th class="two wide">{{ trans("questions.points") }}</th>
                            <th class="two wide">{{ trans("questions.actions") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <ChoiceOrdering v-for="(answer, idx) in question.answers" :key="idx"
                            :model-answer-value="answer" :index="idx" :answer-count="question.answers.length"
                            @update:modelAnswerValue="updateAnswer($event, idx)" @move-up="moveAnswerUp(idx)"
                            @move-down="moveAnswerDown(idx)" @delete="deleteAnswer(idx)" :answer="answer" />
                        <tr v-if="showAddQuestionMessageOrdering">
                            <td colspan="4">
                                <span class="ui message">
                                    {{ trans("questions.press_add_answer") }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <div v-if="question.type === 'Text'">
                <span v-if="showAddQuestionMessageText" class="ui message show_message">
                    {{ trans("questions.press_add_answer") }}
                </span>
                <TextForm v-for="(answer, idx) in question.answers" :key="idx" :model-answer-value="answer" :index="idx"
                    @update:modelAnswerValue="updateAnswer($event, idx)" />
            </div>

            <div v-if="question.type === 'Attachment'">
                <span v-if="showAddQuestionMessageAttachment" class="ui message show_message">
                    {{ trans("questions.press_add_answer") }}
                </span>
                <AttachmentForm v-for="(answer, idx) in question.answers" :key="idx" :model-answer-value="answer"
                    :index="idx" @update:modelAnswerValue="updateAnswer($event, idx)"
                    @update:answer_file_url="updateAnswerLinkUrl($event, idx)" />
            </div>
        </div>
    </div>
</template>

<script>
import { QuestionTypeEnum, EvaluationEnum } from '../../../enums';
import ChoiceOrdering from '../answers/choice-ordering-form.vue';
import ChoiceSelection from '../answers/choice-selection-form.vue';
import TextForm from '../answers/text-form.vue';
import AttachmentForm from '../answers/attachment-form.vue';

export default {
    name: "question-form",
    components: {
        ChoiceSelection,
        ChoiceOrdering,
        TextForm,
        AttachmentForm
    },
    props: {
        modelQuestionValue: Object,
        index: Number,
        questionCount: Number,
    },
    data() {
        return {
            showAddQuestionMessageOrdering: true,
            showAddQuestionMessageSelection: true,
            showAddQuestionMessageText: true,
            showAddQuestionMessageAttachment: true,
            enumValues: { QuestionTypeEnum, EvaluationEnum },
        };
    },
    computed: {
        question: {
            get() {
                return this.modelQuestionValue;
            },
            set(value) {
                this.$emit('update:modelQuestionValue', value);
            }
        }
    },
    watch: {
        'question.text': function (newText) {
            if (newText === '0') {
                this.question.description = '';
            }
        },
        'question.duration_enabled': function (newDurationEnabled) {
            if (newDurationEnabled === '0') {
                this.question.duration = '';
            }
        },
        'question.media_link_check': function (newMediaLinkCheck) {
            if (newMediaLinkCheck === '0') {
                this.question.media_link = '';
            }
        },
        'question.type': function () {
            this.question.answers = [];
            if (this.question.type === 'Choices Selection') {
                this.showAddQuestionMessageSelection = true;
                this.showAddQuestionMessageOrdering = false;
                this.showAddQuestionMessageText = false;
                this.showAddQuestionMessageAttachment = false;
            } else if (this.question.type === 'Choices Ordering') {
                this.showAddQuestionMessageOrdering = true;
                this.showAddQuestionMessageSelection = false;
                this.showAddQuestionMessageText = false;
                this.showAddQuestionMessageAttachment = false;
            } else if (this.question.type === 'Text') {
                this.showAddQuestionMessageOrdering = false;
                this.showAddQuestionMessageSelection = false;
                this.showAddQuestionMessageText = true;
                this.showAddQuestionMessageAttachment = false;
            } else if (this.question.type === 'Attachment') {
                this.showAddQuestionMessageOrdering = false;
                this.showAddQuestionMessageSelection = false;
                this.showAddQuestionMessageText = false;
                this.showAddQuestionMessageAttachment = true;
            } else {
                this.showAddQuestionMessageOrdering = true;
                this.showAddQuestionMessageSelection = true;
                this.showAddQuestionMessageText = true;
                this.showAddQuestionMessageAttachment = true;
            }
        },

        question: {
            handler(newValue) {
                this.$emit('update:modelQuestionValue', newValue);
            },
            deep: true
        }
    },
    methods: {
        updateAnswerLinkUrl(answer_file_url, index) {
            this.question.answers[index].answer_file_url = answer_file_url;
        },
        addAnswer() {
            if (!this.question.answers) {
                this.question.answers = [];
            }
            switch (this.question.type) {
                case 'Choices Selection':
                    this.question.answers.push({
                        text: '',
                        correct: false,
                        points: 0,
                    });
                    this.showAddQuestionMessageSelection = false;
                    break;
                case 'Choices Ordering':
                    this.question.answers.push({
                        text: '',
                        order: this.question.answers.length + 1,
                        points: 0,
                    });
                    this.showAddQuestionMessageOrdering = false;
                    break;
                case 'Text':
                    if (this.question.answers.length === 0) {
                        this.question.answers.push({
                            text: '',
                        });
                    }
                    this.showAddQuestionMessageText = false;
                    break;
                case 'Attachment':
                    if (this.question.answers.length === 0) {
                        this.question.answers.push({
                            answer_file_url: '',
                        });
                    }
                    this.showAddQuestionMessageAttachment = false;
                    break;
            }

            const answersExist = this.question.answers.length > 0;

            if (!answersExist) {
                if (this.question.type === 'Choices Selection') {
                    this.showAddQuestionMessageSelection = true;
                } else if (this.question.type === 'Choices Ordering') {
                    this.showAddQuestionMessageOrdering = true;
                } else if (this.question.type === 'Text') {
                    this.showAddQuestionMessageText = true;
                } else if (this.question.type === 'Attachment') {
                    this.showAddQuestionMessageAttachment = true;
                }

            }

            this.$emit('update:answers', this.question.answers);
        },

        deleteAnswer(index) {
            this.question.answers.splice(index, 1);
            this.$emit('update:answers', this.question.answers);
        },
        updateAnswer(answer, index) {
            this.question.answers.splice(index, 1, answer);
            this.$emit('update:answers', this.question.answers);
        },
        moveAnswerUp(index) {
            if (index > 0) {
                const temp = this.question.answers[index - 1];
                this.question.answers.splice(index - 1, 1, this.question.answers[index]);
                this.question.answers.splice(index, 1, temp);
                this.$emit('update:answers', this.question.answers);
            }
        },
        moveAnswerDown(index) {
            if (index < this.question.answers.length - 1) {
                const temp = this.question.answers[index + 1];
                this.question.answers.splice(index + 1, 1, this.question.answers[index]);
                this.question.answers.splice(index, 1, temp);
                this.$emit('update:answers', this.question.answers);
            }
        },
        trans(key) {
            return trans(key);
        },
        moveUp() {
            this.$emit('move-up', this.index);
        },
        moveDown() {
            this.$emit('move-down', this.index);
        },

    }
};
</script>

<style scoped>
.ui.form {
    margin-top: 10px !important;
    padding: 20px !important;
    background-color: #FFFF;
    border: 0.5px solid #A7A7A7;
}

.text-input,
.media,
.duration,
.bonus_input {
    background-color: #EFEFEF !important;
}

.text-input {
    height: 42px !important;
}

.duration {
    margin-left: 10px !important;
}

.spaced-radio {
    margin-right: 20px;
}

.type_question {
    margin-right: 74px !important;
}

.arrow {
    cursor: pointer;
    color: var(--project-primary-color);
    font-size: 20px;
}

.add_answer {
    background-color: var(--project-primary-color);
    color: white;
    cursor: pointer;
    margin-bottom: 10px;
    border: none;
    width: 122px;
    height: 26px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    top: 10px;
}

.add_answer::before {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    width: 300%;
    height: 300%;
    background-color: rgba(0, 0, 0, 0.1) !important;
    transition: all 0.3s ease;
    border-radius: 50%;
    transform: translate(-50%, -50%) scale(0);
}

.add_answer:hover::before {
    transform: translate(-50%, -50%) scale(1);
}

.arrow_up_down {
    display: flex;
    justify-content: flex-end;
}

.ui.celled.table {
    margin-top: 10px;
}

.ui.celled.table th {
    text-align: center !important;
}

input:focus,
textarea:focus {
    border: 1px solid var(--project-primary-color) !important;
}

.show_message{
    margin-top: 10px !important;
}


</style>
