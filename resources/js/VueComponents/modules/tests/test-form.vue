<template>
    <div class="ui form">
        <div class="field">
            <input
                v-model="testData.title"
                type="text"
                :placeholder="trans('common.title')"
                class="title-input"
            />
        </div>

        <div class="equal width fields">
            <div class="field">
                <label>{{ trans("tests.score") }}</label>
                <input
                    v-model="testData.passing_score"
                    type="number"
                    min="1"
                    class="input_field"
                />
            </div>

            <div class="field">
                <label>{{ trans("tests.duration") }}</label>
                <input
                    v-model="testData.duration"
                    class="input_field"
                    type="number"
                    min="1"
                />
            </div>

            <div class="field">
                <label>{{ trans("tests.allowed_attempts_number") }}</label>
                <input
                    v-model="testData.allowed_attempts_number"
                    class="input_field"
                    type="number"
                    min="1"
                />
            </div>
        </div>

        <div class="equal width fields" style="align-items: center">
            <div class="field">
                <label>{{ trans("tests.report_background_image") }}</label>
                <input
                    @change="backgroundReport"
                    type="file"
                    class="file-input"
                    ref="background_input"
                />
            </div>

            <div class="field">
                <label>{{
                    trans("tests.window_allowed_crossing_duration")
                }}</label>
                <input
                    v-model="testData.window_allowed_crossing_duration"
                    class="input_field"
                    type="number"
                    min="0"
                />
            </div>

            <div class="field">
                <label>{{
                    trans("tests.window_crossing_penalties_number")
                }}</label>
                <input
                    v-model="testData.window_crossing_penalties_number"
                    class="input_field"
                    type="number"
                    min="0"
                />
            </div>
        </div>

        <div v-if="isBackgroundSelected" class="equal width fields">
            <div class="field">
                <label>{{ trans("tests.report_margin_top") }}</label>
                <div class="ui radio checkbox">
                    <input
                        v-model="testData.report_margin_top"
                        type="number"
                        min="0"
                        style="width: 80px"
                    />
                </div>
            </div>

            <div class="field">
                <label>{{ trans("tests.report_margin_buttom") }}</label>
                <div class="ui radio checkbox">
                    <input
                        v-model="testData.report_margin_buttom"
                        type="number"
                        min="0"
                        style="width: 80px"
                    />
                </div>
            </div>

            <div class="field">
                <label>{{ trans("tests.report_margin_left") }}</label>
                <div class="ui radio checkbox">
                    <input
                        v-model="testData.report_margin_left"
                        type="number"
                        min="0"
                        style="width: 80px"
                    />
                </div>
            </div>

            <div class="field">
                <label>{{ trans("tests.report_margin_right") }}</label>
                <div class="ui radio checkbox">
                    <input
                        v-model="testData.report_margin_right"
                        type="number"
                        min="0"
                        style="width: 80px"
                    />
                </div>
            </div>
        </div>

        <div class="equal width fields" style="align-items: center">
            <div class="field">
                <label>{{ trans("tests.question_selection") }}</label>

                <div
                    class="ui radio checkbox"
                    v-for="(
                        questionSelect, index
                    ) in enumValues.QuestionSelectionEnum"
                    :key="index"
                >
                    <input
                        type="radio"
                        name="question_selection"
                        :value="questionSelect.code"
                        v-model="testData.question_selection"
                    />
                    <label>{{ questionSelect.name }}</label>
                </div>
                <input
                    v-if="testData.question_selection === 'Fixed'"
                    v-model="testData.fixedValue"
                    type="number"
                    name="fixedValue"
                    class="fixed"
                    style="
                        width: 60px;
                        padding: 0px;
                        text-align-last: center;
                        height: 25px;
                    "
                />
            </div>

            <!-- <div class="field" v-if="testData.question_selection === 'Fixed'">
                <label></label>
            </div> -->

            <div class="field">
                <label>{{ trans("tests.accessibility") }}</label>

                <div
                    class="ui radio checkbox"
                    v-for="(
                        testVisibility, index
                    ) in enumValues.TestVisibilityEnum"
                    :key="index"
                >
                    <input
                        v-model="testData.visibility"
                        type="radio"
                        name="visibility"
                        :value="testVisibility.code"
                    />
                    <label>{{ testVisibility.name }}</label>
                </div>
            </div>

            <div class="field">
                <label>{{ trans("tests.is_camera_required") }}</label>

                <div class="ui radio checkbox">
                    <input
                        v-model="testData.is_camera_required"
                        type="radio"
                        name="is_camera_required"
                        value="1"
                    />
                    <label>{{ trans("tests.yes") }}</label>
                </div>

                <div class="ui radio checkbox">
                    <input
                        v-model="testData.is_camera_required"
                        type="radio"
                        name="is_camera_required"
                        value="0"
                    />
                    <label>{{ trans("tests.no") }}</label>
                </div>
            </div>

            <div class="field">
                <label>{{ trans("tests.is_audio_required") }}</label>

                <div class="ui radio checkbox">
                    <input
                        v-model="testData.is_audio_required"
                        type="radio"
                        name="is_audio_required"
                        value="1"
                    />
                    <label>{{ trans("tests.yes") }}</label>
                </div>

                <div class="ui radio checkbox">
                    <input
                        v-model="testData.is_audio_required"
                        type="radio"
                        name="is_audio_required"
                        value="0"
                    />
                    <label>{{ trans("tests.no") }}</label>
                </div>
            </div>
        </div>

        <div class="equal width fields">
            <div class="field">
                <label>{{ trans("tests.description") }}</label>
                <textarea
                    v-model="testData.description"
                    :placeholder="trans('tests.description') + '...'"
                    class="description-input"
                ></textarea>
            </div>

            <div class="field">
                <label>{{ trans("tests.thumbnail") }}</label>
                <input
                    @change="thumbnailChanged"
                    type="file"
                    class="file-input"
                    ref="thumbnail_input"
                />

                <div
                    v-if="!thumbnail_url"
                    @click="triggerThumbnailInput"
                    class="ui placeholder segment upload-container"
                >
                    <div class="ui icon header">
                        <i class="upload icon"></i>
                        {{ trans("tests.upload") }}
                    </div>
                </div>

                <div v-if="thumbnail_url" class="thumbnail-viewer">
                    <img :src="thumbnail_url" alt="thumbnail" />
                </div>
            </div>
        </div>
    </div>

    <div class="ui form">
        <div>
            <div v-for="(question, index) in testData.questions" :key="index">
                <question-form
                    :ref="'questionForm-' + index"
                    :model-question-value="question"
                    :index="index"
                    :question-count="testData.questions.length"
                    @update:modelQuestionValue="updateQuestion($event, index)"
                    @move-up="moveQuestionUp(index)"
                    @move-down="moveQuestionDown(index)"
                    @update:answers="updateAnswers($event, index)"
                />
            </div>
            <div class="valid_add">
                <button @click="addQuestion" class="add_question">
                    <i class="plus icon" style="visibility: visible"></i>
                    {{ trans("tests.add_question") }}
                </button>
                <button @click="submitTest" class="valid_question">
                    <i
                        class="icon checkmark checkmark-icon"
                        style="visibility: visible"
                    ></i>
                    {{
                        this.test?.id
                            ? trans("tests.update_test")
                            : trans("tests.save_test")
                    }}
                </button>
            </div>
        </div>
    </div>
    <Toast />
</template>

<script>
import { QuestionSelectionEnum, TestVisibilityEnum } from "../../../enums";
import questionForm from "../questions/question-form.vue";
import axios from "axios";
/* import { handleLaravelAxiosErrorResponse } from "../../../app"; */
import { useToast } from "primevue/usetoast";
import Toast from "primevue/toast";

export default {
    name: "TestForm",
    components: { questionForm, Toast },
    props: {
        id: {
            type: String,
        },
        test: {
            type: Object,
        },
    },
    data() {
        return {
            enumValues: {
                QuestionSelectionEnum,
                TestVisibilityEnum,
            },
            testData: {
                title: "",
                description: "",
                duration: null,
                report_margin_right: null,
                report_margin_left: null,
                report_margin_buttom: null,
                report_margin_top: null,
                passing_score: null,
                question_selection: null,
                allowed_attempts_number: null,
                window_allowed_crossing_duration: null,
                window_crossing_penalties_number: null,
                visibility: null,
                is_camera_required: null,
                is_audio_required: null,
                fixedValue: null,
                questions: [],
            },
            thumbnail_url: null,
            background_url: null,
            isBackgroundSelected: false,
        };
    },
    watch: {
        test: {
            handler(newTestValue) {
                if (newTestValue) {
                    this.setTestData(newTestValue);
                }
            },
            immediate: true,
        },
    },
    setup() {
        const toast = useToast();
        return { toast };
    },
    methods: {
        setTestData(test) {
            this.testData = {
                title: test.title,
                description: test.description,
                duration: test.duration,
                report_margin_right: test.report_margin_right,
                report_margin_left: test.report_margin_left,
                report_margin_top: test.report_margin_top,
                report_margin_buttom: test.report_margin_buttom,
                passing_score: test.passing_score,
                question_selection: test.question_selection,
                allowed_attempts_number: test.allowed_attempts_number,
                window_allowed_crossing_duration:
                    test.window_allowed_crossing_duration,
                window_crossing_penalties_number:
                    test.window_crossing_penalties_number,
                visibility: test.visibility,
                is_camera_required:
                    test.is_camera_required === true ? "1" : "0",
                is_audio_required: test.is_audio_required === true ? "1" : "0",
                fixedValue: test.fixed_value,
                questions: test.questions.map((question) => ({
                    id: question.id,
                    text: question.text ? "1" : "0",
                    description: question.text,
                    media_link_check: question.media_link_check ? "0" : "1",
                    media_link: question.media_link,
                    duration_enabled: question.duration ? "1" : "0",
                    evaluation_type: question.evaluation_type,
                    require_manual_evaluation:
                        question.require_manual_evaluation ? "1" : "0",
                    type: question.type,
                    duration: question.duration,
                    first_place_bonus:
                        question.answers.length > 0
                            ? question.answers[0].first_place_bonus
                            : 0,
                    second_place_bonus:
                        question.answers.length > 1
                            ? question.answers[1].second_place_bonus
                            : 0,
                    third_place_bonus:
                        question.answers.length > 2
                            ? question.answers[2].third_place_bonus
                            : 0,
                    answers: question.answers.map((answer, index) => ({
                        id: answer.id,
                        text: answer.text,
                        correct:
                            answer.correct_value !== null
                                ? answer.correct_value
                                : undefined,
                        order: answer.order,
                        points: answer.points,
                        answer_file_url: answer.answer_file,
                    })),
                })),
            };
            this.thumbnail_url = test.thumbnail;
            this.background_url = test.report_background_image;
            this.isBackgroundSelected =
                this.background_url !== null && this.background_url !== "";
        },

        updateQuestion(question, index) {
            this.testData.questions.splice(index, 1, question);
        },
        moveQuestionUp(index) {
            if (index > 0) {
                const temp = this.testData.questions[index - 1];
                this.testData.questions.splice(
                    index - 1,
                    1,
                    this.testData.questions[index]
                );
                this.testData.questions.splice(index, 1, temp);
            }
        },
        moveQuestionDown(index) {
            if (index < this.testData.questions.length - 1) {
                const temp = this.testData.questions[index + 1];
                this.testData.questions.splice(
                    index + 1,
                    1,
                    this.testData.questions[index]
                );
                this.testData.questions.splice(index, 1, temp);
            }
        },
        updateAnswers(answers, index) {
            this.testData.questions[index].answers = answers;
        },
        addQuestion() {
            this.testData.questions.push({
                text: "",
                media_link: "",
                duration_enabled: false,
                require_manual_evaluation: false,
                evaluation_type: "",
                type: "",
                duration: "",
            });
        },
        async submitTest() {
            console.log(this.test);
            const url = this.test?.id
                ? `/api/tests/edit/${this.test.id}`
                : "/api/tests";
            const method = this.test?.id ? "put" : "post";
            const data = {
                title: this.testData.title,
                description: this.testData.description,
                thumbnail: this.thumbnail_url,
                report_background_image: this.background_url,
                duration: this.testData.duration,
                report_margin_buttom: this.testData.report_margin_buttom,
                report_margin_left: this.testData.report_margin_left,
                report_margin_right: this.testData.report_margin_right,
                report_margin_top: this.testData.report_margin_top,
                start_at: new Date().toISOString(),
                end_at: new Date(
                    Date.now() + this.testData.duration * 60000
                ).toISOString(),
                passing_score: this.testData.passing_score,
                question_selection: this.testData.question_selection,
                questions_number: this.testData.questions.length,
                allowed_attempts_number: this.testData.allowed_attempts_number,
                window_allowed_crossing_duration:
                    this.testData.window_allowed_crossing_duration,
                window_crossing_penalties_number:
                    this.testData.window_crossing_penalties_number,
                visibility: this.testData.visibility,
                is_camera_required: this.testData.is_camera_required,
                is_audio_required: this.testData.is_audio_required,
                questions: this.testData.questions.map((question, index) => ({
                    id: this.test?.questions?.id ?? null,
                    text: question.description,
                    media_link: question.media_link,
                    evaluation_type: question.evaluation_type,
                    type: question.type,
                    order: index + 1,
                    duration: question.duration,
                    require_manual_evaluation:
                        question.require_manual_evaluation,
                    answers: question.answers.map((answer, answerIndex) => ({
                        id: this.test?.questions?.answers?.id ?? null,
                        text: answer.text ? answer.text : "Attachment",
                        order: answer.order ?? answerIndex + 1,
                        correct_value:
                            typeof answer.correct !== "undefined"
                                ? answer.correct
                                : null,
                        points: answer.points ?? 1,
                        answer_file: answer.answer_file_url ?? null,
                        first_place_bonus: question.first_place_bonus ?? 0,
                        second_place_bonus: question.second_place_bonus ?? 0,
                        third_place_bonus: question.third_place_bonus ?? 0,
                    })),
                })),
            };

            try {
                const response = await axios({
                    method: method,
                    url: url,
                    data: data,
                    headers: {
                        Authorization: `Bearer ${$(
                            'meta[name="csrf-token"]'
                        ).attr("content")}`,
                    },
                });

                if (response.status === 200 || response.status === 201) {
                    console.log("Server response:", response.data);
                    this.toast.add({
                        severity: "success",
                        summary: "Success",
                        detail: `Test ${
                            this.test?.id ? "updated" : "created"
                        } successfully`,
                        life: 3000,
                    });

                    if (this.test?.id) {
                        setTimeout(() => {
                            this.$router.push("/tests");
                        }, 0);
                    }
                    if (response.status === 201) {
                        this.resetForm();
                    }
                } else {
                    console.error(
                        "Test creation/updating failed: No ID returned."
                    );
                }
            } catch (error) {
                handleLaravelAxiosErrorResponse(error);
            }
        },

        resetForm() {
            this.testData.title = "";
            this.testData.description = "";
            this.testData.duration = null;
            this.testData.report_margin_buttom = null;
            this.testData.report_margin_left = null;
            this.testData.report_margin_right = null;
            this.testData.report_margin_top = null;
            this.testData.passing_score = null;
            this.testData.question_selection = null;
            this.testData.allowed_attempts_number = null;
            this.testData.window_allowed_crossing_duration = null;
            this.testData.window_crossing_penalties_number = null;
            this.testData.visibility = null;
            this.testData.is_camera_required = null;
            this.testData.is_audio_required = null;
            this.testData.fixedValue = null;
            this.testData.questions = [];
            this.thumbnail_url = null;
            this.background_url = null;
            this.$refs.background_input.value = "";
            this.$refs.thumbnail_input.value = "";
        },
        trans(key) {
            return trans(key);
        },
        thumbnailChanged(event) {
            let thumbnail = event.target.files[0];
            if (thumbnail) {
                let reader = new FileReader();
                reader.readAsDataURL(thumbnail);
                reader.onload = (event) => {
                    this.thumbnail_url = event.target.result;
                };
            }
        },
        backgroundReport(event) {
            let background = event.target.files[0];
            if (background) {
                let reader = new FileReader();
                reader.readAsDataURL(background);
                reader.onload = (event) => {
                    this.background_url = event.target.result;
                    this.isBackgroundSelected = true;
                };
            }
        },
    },
};
</script>

<style scoped>
.ui.checkbox {
    margin-top: 0 !important;
}

.ui.checkbox label {
    margin-right: 10px !important;
}

.upload-container {
    min-height: 13rem !important;
    cursor: pointer;
}

.file-input {
    cursor: pointer;
}

.description-input {
    min-height: 17rem !important;
}

.title-input {
    border: none !important;
    background-color: transparent !important;
    font-size: 32px !important;
    border-bottom: 1.5px solid #000000 !important;
    border-radius: 0 !important;
    width: fit-content !important;
}

.thumbnail-viewer {
    height: 13rem !important;
    border: 1px solid #d9d2d2;
    display: flex;
    align-items: center;
    justify-content: center;
}

.thumbnail-viewer img {
    height: 100%;
    width: 100%;
    object-fit: contain;
}

.add_question,
.valid_question {
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
}

.add_question::before,
.valid_question::before {
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

.add_question:hover::before,
.valid_question:hover::before {
    transform: translate(-50%, -50%) scale(1);
}

.valid_add {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}

.ui.form .equal.width.fields .field textarea:focus {
    border: 1px solid var(--project-primary-color) !important;
}
</style>
