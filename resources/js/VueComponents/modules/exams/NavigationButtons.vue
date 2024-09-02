<template>
    <div class="ui segment">
        <div class="ui grid stackable">
            <div class="four wide column">
                <button class="ui button" @click="handlePrev" :disabled="currentQuestion === 1">
                    {{ trans("exams.previous") }}
                </button>
            </div>
            <div class="eight wide column center aligned">
                <div class="ui buttons">
                    <button v-for="n in filteredQuestions.length" :key="n"
                        :class="{ 'ui button': true, active: n === currentQuestion }" @click="goToQuestion(n)"
                        :disabled="areInputsDisabled">
                        {{ n }}
                    </button>
                </div>
            </div>
            <div class="four wide column right aligned">
                <button :class="['ui button', { 'primary': isLastQuestion, '': !isLastQuestion }]" @click="handleNext"
                    :disabled="isSubmitted">
                    {{ nextButtonText }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue';

export default {
    name: "NavigationButtons",
    props: {
        currentQuestion: {
            type: Number,
            required: true
        },
        filteredQuestions: {
            type: Array,
            required: true
        },
        isSubmitted: {
            type: Boolean,
            required: true
        },
        currentQuestionData: {
            type: Object,
            required: true
        },
        isNextButtonClicked: {
            type: Boolean,
            default: false
        },
        isQuestionExpired: {
            type: Boolean,
            default: false
        }
    },
    setup(props, { emit }) {
        const trans = (key) => {
            return window.trans(key);
        };

        const isLastQuestion = computed(() => {
            return props.currentQuestion === props.filteredQuestions.length;
        });

        const nextButtonText = computed(() => {
            return isLastQuestion.value ? trans("exams.submit") : trans("exams.next");
        });

        const areInputsDisabled = computed(() => {
            return props.currentQuestionData.duration > 0 && (props.isQuestionExpired || props.isNextButtonClicked);
        });

        const handlePrev = () => {
            if (props.currentQuestion > 1) {
                emit('prevQuestion');
            }
        };

        const handleNext = () => {
            if (isLastQuestion.value) {
                handleSubmit();
            } else {
                emit('nextQuestion');
            }
        };

        const goToQuestion = (n) => {
            emit('goToQuestion', n);
        };

        const handleSubmit = () => {
            emit('submitAnswer');
        };

        return {
            trans,
            handlePrev,
            handleNext,
            goToQuestion,
            handleSubmit,
            isLastQuestion,
            nextButtonText,
            areInputsDisabled
        };
    }
};
</script>

<style scoped>
.ui.buttons .button {
    margin: 0 2px;
}

.ui.buttons .active {
    background-color: var(--project-primary-color);
    color: white;
}

.ui.button.primary {
    background-color: #1678c2;
    color: white;
    font-weight: bold;
    padding: 12px 20px;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.ui.button.primary:hover {
    background-color: #0e568d;
}

.ui.button.primary:active {
    background-color: #0a5a8d;
}
</style>
