<template>
    <div class="ui container">
        <div class="ui three stackable cards">
            <div class="ui card" v-for="exam in exams" :key="exam.userTestAttemptId"
                :class="['status-card', statusClass(exam.status)]">
                <div class="content">
                    <div class="header">Email: {{ exam.userEmail }}</div>
                    <div :class="['status', statusClass(exam.status)]">{{ exam.status }}</div>
                </div>
                <div class="content">
                    <div class="description">
                        <ul>
                            <li>Score: {{ exam.totalPoints }} </li>
                            <li>{{ trans("exams.questions_answered") }}: {{ exam.answeredQuestionsCount }} / {{
                                exam.nombreOfQuestion }}</li>
                            <li>{{ trans("exams.time_spent") }}: {{ formatTime(exam.totalTimeSpent) }}</li>
                            <li>{{ trans("exams.total_test_duration_remaining") }}: {{
                                formatTime(exam.totalTimeRemaining) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
    name: "ExamControl",
    setup() {
        const exams = ref([]);

        const trans = (key) => {
            return window.trans(key);
        };
        const formatTime = (seconds) => {
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = seconds % 60;
            return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
        };

        const statusClass = (status) => {
            switch (status) {
                case 'Failed':
                case 'Cheated':
                    return 'status-failed';
                case 'Passed':
                    return 'status-passed';
                case 'In Progress':
                    return 'status-in-progress';
                default:
                    return '';
            }
        };

        const initializePusher = () => {
            const echo = window.Echo;

            const channel = echo.channel('exam');

            channel.listen('.exam.event', (data) => {
                console.log('Received data:', data);

                const examIndex = exams.value.findIndex(exam => exam.userTestAttemptId === data.userTestAttemptId);

                if (examIndex !== -1) {
                    exams.value[examIndex] = { ...exams.value[examIndex], ...data };
                } else {
                    exams.value.push(data);
                }
            });

            channel.on('pusher:subscription_succeeded', () => {
                console.log('Successfully subscribed to channel:', channel.name);
            });

            channel.on('pusher:subscription_error', (status) => {
                console.error('Subscription error:', status);
            });

            channel.on('pusher:error', (error) => {
                console.error('Pusher error:', error);
            });
        };

        onMounted(() => {
            initializePusher();
        });

        return {
            exams,
            formatTime,
            statusClass,
            trans
        };

    },
};
</script>

<style scoped>
.ui.container {
    padding-top: 2rem;
}

.ui.card {
    padding: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    position: relative;
}

.status-card.status-failed {
    border-color: #d9534f;
}

.status-card.status-passed {
    border-color: #5cb85c;
}

.status-card.status-in-progress {
    border-color: #f0ad4e;
}

.ui.card ul {
    list-style: none;
    padding: 0;
}

.ui.card li {
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.status {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 0.9rem;
    font-weight: bold;
    padding: 0.3rem 0.6rem;
    border-radius: 5px;
}

.status-failed {
    background: #ffdddd;
    color: #d9534f;
}

.status-passed {
    background: #ddffdd;
    color: #5cb85c;
}

.status-in-progress {
    background: #fff8b3;
    color: #f0ad4e;
}
</style>
