<template>
    <div class="ui segment stackable">
        <div class="ui grid">
            <div class="sixteen wide mobile twelve wide tablet twelve wide computer column">
                <div class="ui segment" style="position: relative;">
                    <div class="ui header">{{ trans("exams.question") }} {{ currentQuestion }} {{ trans("exams.of") }}
                        {{ filteredQuestions.length }}</div>
                    <div class="ui field">
                        <label :for="'question' + currentQuestion">{{ currentQuestionData.text }}</label>
                    </div>
                </div>
            </div>
            <div class="four wide mobile four wide tablet four wide computer column">
                <div class="ui right aligned circle"
                    :style="{ background: 'conic-gradient(var(--project-primary-color) ' + progressPercentage + '%, #ccc ' + progressPercentage + '%)' }">
                    <span class="percentage-text">{{ progressPercentage }}%</span>
                </div>
            </div>
        </div>
    </div>

    <div class="ui segment stackable">
        <div class="ui stackable grid">
            <div class="twelve wide column">
                <div class="ui form" v-if="currentQuestionData">
                    <template v-if="currentQuestionData.type === 'Choices Selection'">
                        <div class="ui three column stackable grid">
                            <div class="row">
                                <div class="ui checkbox option column" v-for="answer in currentQuestionData.answers"
                                    :key="answer.id">
                                    <input type="checkbox" :name="'question' + currentQuestion" :value="answer.id"
                                        :id="'question' + currentQuestion + answer.id"
                                        v-model="selectedAnswers[answer.id]" @change="updateUserAnswers"
                                        :class="{ 'custom-checkbox': selectedAnswers[answer.id] }"
                                        :disabled="isQuestionExpired">
                                    <label :for="'question' + currentQuestion + answer.id">{{ answer.text }}</label>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template v-else-if="currentQuestionData.type === 'Choices Ordering'">
                        <div class="ui form">
                            <div class="inline fields" v-for="answer in currentQuestionData.answers" :key="answer.id">
                                <div class="ten wide field">
                                    <input type="number" placeholder="Order" v-model="answerOrder[answer.id]"
                                        @change="updateUserAnswers" :disabled="isQuestionExpired">
                                    <span>{{ answer.text }}</span>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template v-else-if="currentQuestionData.type === 'Text'">
                        <div class="ui field" v-for="answer in currentQuestionData.answers" :key="answer.id">
                            <textarea v-model="textAnswer[answer.id]" placeholder="Répondez ici..." rows="4"
                                @input="updateUserAnswers" :disabled="isQuestionExpired"></textarea>
                        </div>
                    </template>

                    <template v-else-if="currentQuestionData.type === 'Attachment'">
                        <div class="ui eight wide field">
                            <input type="file" @change="handleFileUpload($event)" :disabled="isQuestionExpired">
                        </div>
                    </template>
                </div>
            </div>

            <div class="four wide column center aligned">
                <div class="circle-container">
                    <div v-if="currentQuestionData.duration">
                        <div v-if="currentTimeRemaining > 0" class="ui header">{{ trans("exams.remaining_time") }}</div>
                        <div class="ui small horizontal statistic timer" :data-time-remaining="currentTimeRemaining">
                            <div class="value" :class="{ 'flashing-red': currentTimeRemaining < 3 }"
                                v-if="currentTimeRemaining > 0">
                                <i class="stopwatch icon"></i>
                                {{ formatTime(currentTimeRemaining) }}
                            </div>
                            <div v-else class="answered-message">
                                <span>{{ trans("exams.this_question_is_answered") }}</span>
                            </div>
                        </div>
                        <div class="ui header" v-if="currentQuestionData && currentTimeRemaining > 0">
                            {{ trans("exams.question_duration") }} : {{ formatTime(currentQuestionData.duration) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, watch, computed } from 'vue';

export default {
    name: 'QuestionAnswers',

    props: {
        currentTimeRemaining: {
            type: Number,
            required: true,
        },
        currentQuestion: {
            type: Number,
            required: true,
        },
        filteredQuestions: {
            type: Array,
            required: true,
        },
        currentQuestionData: {
            type: Object,
            required: true,
        },
        progressPercentage: {
            type: Number,
            required: true,
        },
        userAnswers: {
            type: Array,
            required: true,
        },
        expiredQuestions: {
            type: Array,
            required: true,
        },
    },
    emits: ['uploadAttachment'],

    setup(props, context) {
        const trans = (key) => {
            return window.trans(key);
        };
        const answerOrder = ref({});
        const textAnswer = ref({});
        const selectedAnswers = ref({});
        const uploadedFile = ref(null);
        const isQuestionExpired = computed(() => {
            return props.currentQuestionData.duration > 0 && props.expiredQuestions.includes(props.currentQuestion);
        });

        watch(() => props.currentQuestionData, (newVal) => {
            if (newVal) {
                restoreAnswers();
            }
        }, { immediate: true });

        watch(textAnswer, updateUserAnswers, { deep: true });
        watch(selectedAnswers, updateUserAnswers, { deep: true });
        watch(answerOrder, updateUserAnswers, { deep: true });

        function restoreAnswers() {
            const currentAnswer = props.userAnswers.find(answer => answer.answer_id === props.currentQuestionData.id);
            if (currentAnswer) {
                if (props.currentQuestionData.type === 'Choices Selection') {
                    selectedAnswers.value = currentAnswer.value || {};
                } else if (props.currentQuestionData.type === 'Choices Ordering') {
                    answerOrder.value = currentAnswer.value || {};
                } else if (props.currentQuestionData.type === 'Text') {
                    textAnswer.value = currentAnswer.value || {};
                }
            } else {
                resetAnswers();
            }
        }

        function formatTime(time) {
            if (!isNaN(time)) {
                const minutes = Math.floor(time / 60);
                const seconds = time % 60;
                return `${minutes}:${seconds.toString().padStart(2, '0')}`;
            }
            return '';
        }

        function resetAnswers() {
            answerOrder.value = {};
            textAnswer.value = {};
            selectedAnswers.value = {};
        }

        function handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                readFileAsBase64(file).then(answer_file => {
                    uploadedFile.value = answer_file;
                    context.emit('uploadAttachment', {
                        questionIndex: props.currentQuestion - 1,
                        answer: {
                            answer_id: props.currentQuestionData.id,
                            value: answer_file,
                        },
                    });
                });
            }
        }

        function updateUserAnswers() {
            let answerValue = null;

            if (props.currentQuestionData.type === 'Choices Selection') {
                answerValue = selectedAnswers.value;
            } else if (props.currentQuestionData.type === 'Choices Ordering') {
                answerValue = answerOrder.value;
            } else if (props.currentQuestionData.type === 'Text') {
                answerValue = textAnswer.value;
            } else if (uploadedFile.value) {
                answerValue = uploadedFile.value;
            }

            const pointsEarned = calculatePointsEarned(selectedAnswers.value, answerOrder.value, props.currentQuestionData.answers);
            const index = props.userAnswers.findIndex(answer => answer.answer_id === props.currentQuestionData.id);

            if (index !== -1) {
                props.userAnswers.splice(index, 1, {
                    answer_id: props.currentQuestionData.id,
                    value: answerValue,
                    points_earned: pointsEarned
                });
            } else {
                props.userAnswers.push({
                    answer_id: props.currentQuestionData.id,
                    value: answerValue,
                    points_earned: pointsEarned
                });
            }
        }


        function calculatePointsEarned(selectedAnswers, answerOrder, answers) {
            let totalPointsEarned = 0;

            if (selectedAnswers) {
                let allCorrect = true;
                Object.keys(selectedAnswers).forEach(selectedAnswerId => {
                    const answer = answers.find(ans => ans.id === parseInt(selectedAnswerId));
                    if (answer) {
                        if (selectedAnswers[selectedAnswerId] && answer.correct_value === selectedAnswers[selectedAnswerId].toString()) {
                            const index = answers.findIndex(ans => ans.id === answer.id);
                            switch (index) {
                                case 0:
                                    totalPointsEarned += answer.first_place_bonus || 0;
                                    break;
                                case 1:
                                    totalPointsEarned += answer.second_place_bonus || 0;
                                    break;
                                case 2:
                                    totalPointsEarned += answer.third_place_bonus || 0;
                                    break;
                                default:
                                    break;
                            }
                        } else {
                            allCorrect = false;
                        }
                    }
                });
                if (!allCorrect) {
                    totalPointsEarned = 0;
                }
            }

            if (answerOrder) {
                let allCorrect = true;
                Object.keys(answerOrder).forEach(answerId => {
                    const answer = answers.find(ans => ans.id === parseInt(answerId));
                    if (answer) {
                        if (answerOrder[answerId] === answer.order) {
                            const index = answers.findIndex(ans => ans.id === answer.id);
                            switch (index) {
                                case 0:
                                    totalPointsEarned += answer.first_place_bonus || 0;
                                    break;
                                case 1:
                                    totalPointsEarned += answer.second_place_bonus || 0;
                                    break;
                                case 2:
                                    totalPointsEarned += answer.third_place_bonus || 0;
                                    break;
                                default:
                                    break;
                            }
                        } else {
                            allCorrect = false;
                        }
                    }
                });
                if (!allCorrect) {
                    totalPointsEarned = 0;
                }
            }

            return totalPointsEarned;
        }



        function addOrUpdateAnswer(newAnswer) {
            const index = props.userAnswers.findIndex(answer => answer.answer_id === newAnswer.answer_id);
            if (index !== -1) {
                props.userAnswers.splice(index, 1, newAnswer);
            } else {
                props.userAnswers.push(newAnswer);
            }
        }

        function readFileAsBase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = () => resolve(reader.result.split(',')[1]);
                reader.onerror = error => reject(error);
            });
        }

        return {
            trans,
            answerOrder,
            textAnswer,
            selectedAnswers,
            uploadedFile,
            isQuestionExpired,
            restoreAnswers,
            formatTime,
            resetAnswers,
            handleFileUpload,
            updateUserAnswers,
            calculatePointsEarned,
            addOrUpdateAnswer,
            readFileAsBase64,
        };
    },
};
</script>

<style scoped>
.flashing-red {
    color: red !important;
    animation: blink-animation 1s steps(5, start) infinite !important;
}

@keyframes blink-animation {
    to {
        visibility: hidden;
    }
}

input[type="checkbox"].custom-checkbox:checked+label::before {
    border-color: var(--project-primary-color) !important;
}

.ui.checkbox.option.column {
    margin: 5px !important;
    cursor: pointer;
}

.ui.input {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
}

.ui.checkbox.option {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
}

.ui.checkbox.option:hover {
    background-color: #e6f7ff;
}

.ui.checkbox.option input[type="radio"] {
    margin-right: 10px;
}

.ui.checkbox.option label {
    font-weight: bold;
    color: #333;
}

.percentage-text {
    font-size: 24px;
    font-weight: bold;
    color: white;
}

.circle-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}

.percentage-text {
    font-size: 20px;
}

.ui.form .inline.fields .wide.field>input,
.ui.form .inline.fields .wide.field>select {
    width: 20%;
}

input:focus,
textarea:focus {
    border: 1px solid var(--project-primary-color) !important;
}

.answered-message {
    text-align: center;
    padding: 10px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-top: 10px;
    font-weight: bold;
    color: #666;
}
</style>
