<template>
    <div class="ui segment">
        <div class="ui grid stackable">
            <div class="twelve wide column">
                <div class="ui header">{{ trans("exams.remaining_time") }}</div>
                <div class="ui timer" :data-time-remaining="currentTimeRemaining">
                    <i class="stopwatch icon" style="visibility: visible;"></i>
                    {{ formatTime(currentTimeRemaining) }}
                </div>
                <div class="ui header" v-if="currentQuestionData">
                    {{ trans("exams.question_duration") }} : {{ formatTime(currentQuestionData.duration) }}
                </div>
            </div>
            <div class="four wide column right aligned">
                <button class="ui button primary" @click="handleSubmit" :disabled="isSubmitted" >{{ trans("exams.submit") }}</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        currentTimeRemaining: {
            type: Number,
            required: true
        },
        currentQuestionData: {
            type: Object,
            required: true
        },
        isSubmitted: {
            type: Boolean,
            required: true
        }
    },
    methods: {
        trans(key) {
            return trans(key);
        },
        formatTime(time) {
            if (!isNaN(time)) {
                const minutes = Math.floor(time / 60);
                const seconds = time % 60;
                return `${minutes}:${seconds.toString().padStart(2, '0')}`;
            }
            return '';
        },
        handleSubmit() {
            this.$emit('submitAnswer');
        }
    }
};
</script>

<style scoped>
.ui.timer {
    font-size: 3rem;
    font-weight: bold;
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
