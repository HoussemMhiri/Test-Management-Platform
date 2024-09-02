<template>
    <div class="ui container" @mouseenter="handleMouseEnter" @mouseleave="handleMouseLeave">
        <div v-if="isLoading" class="ui active inverted dimmer">
            <div class="ui text loader">submitting</div>
        </div>
        <div class="ui stackable grid exam" v-if="!isCheated">
            <div class="sixteen wide column">
                <div class="ui stackable grid" style="font-style: italic; text-align-last: end; align-items: center;">
                    <div class="three wide column">
                        <img src="https://studymock.com/assets/images/logo.svg" alt="Logo" class="ui medium image">
                    </div>
                    <div class="six wide column">
                        <h1 class="ui huge header">{{ testTitle }}</h1>
                    </div>
                    <div v-if="!testFinished && !isSubmitted" class="seven wide column aligned right">
                        <div class="ui Normal horizontal statistic" style="align-items: end;">
                            <h3 class="ui header">{{ trans("exams.test_duration") }}</h3>
                            <div class="value" :class="{ 'flashing-red': totalTestDurationRemaining < 10 }"
                                style="align-items: flex-end;">
                                <i class="stopwatch icon"></i>
                                {{ formatTime(totalTestDurationRemaining) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="!testFinished && !isSubmitted" class="sixteen wide column">
                <div class="ui stackable grid">
                    <div class="sixteen wide column">
                        <QuestionAnswers :key="currentQuestion" :currentQuestion="currentQuestion"
                            :currentTimeRemaining="currentTimeRemaining" :filteredQuestions="filteredQuestions"
                            :currentQuestionData="currentQuestionData" :progressPercentage="progressPercentage"
                            :userAnswers="userAnswers" :expiredQuestions="expiredQuestions"
                            @uploadAttachment="handleUploadAttachment" />
                    </div>
                    <div class="sixteen wide column" v-if="passingMode === 'INDIVIDUAL'">
                        <NavigationButtons :currentQuestion="currentQuestion" :filteredQuestions="filteredQuestions"
                            :isSubmitted="isSubmitted" :currentQuestionData="currentQuestionData"
                            @prevQuestion="prevQuestion" @goToQuestion="goToQuestion" @nextQuestion="nextQuestion"
                            @submitAnswer="submitAnswer" @testCompleted="testCompleted" />
                    </div>
                </div>
            </div>

            <div v-else class="sixteen wide column">
                <div v-if="isPassed" class="sixteen wide column">
                    <div class="ui segment">
                        <h2 class="ui center aligned icon header test-complete">
                            <i class="check circle outline icon"></i>
                            <i class="fas fa-trophy"></i>
                            {{ trans("exams.test_complete") }}
                        </h2>
                        <div class="ui two column very relaxed grid">
                            <div class="column">
                                <div class="ui statistic">
                                    <div class="value">{{ answeredQuestionsCount }} / {{ numberQuestion }}</div>
                                    <div class="label">{{ trans("exams.number_of_questions_answered") }}
                                    </div>
                                </div>
                            </div>
                            <div class="column total-time-spent">
                                <div class="ui statistic">
                                    <div class="value">{{ formatTime(totalTimeSpent) }}</div>
                                    <div class="label">{{ trans("exams.time_spent") }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="ui divider"></div>
                        <div class="ui segment">
                            <h3 class="ui header">{{ trans("exams.congratulations") }} !</h3>
                            <p>{{ trans("exams.you_have_completed") }}</p>
                            <div class="ui buttons eight wide column">
                                <button class="ui primary button result" @click="navigateToDashboard">{{
                                    trans("exams.go_to_dash") }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="sixteen wide column">
                    <div class="ui segment">
                        <h2 class="ui center aligned icon header test-failed">
                            <i class="times circle outline icon"></i>
                            {{ trans("exams.test_failed") }}
                        </h2>
                        <div class="ui two column very relaxed grid">
                            <div class="column">
                                <div class="ui statistic">
                                    <div class="value">{{ answeredQuestionsCount }} / {{ numberQuestion }}</div>
                                    <div class="label">{{ trans("exams.number_of_questions_answered") }}</div>
                                </div>
                            </div>
                            <div class="column total-time-spent">
                                <div class="ui statistic">
                                    <div class="value">{{ formatTime(totalTimeSpent) }}</div>
                                    <div class="label">{{ trans("exams.time_spent") }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="ui divider"></div>
                        <div class="ui segment">
                            <h3 class="ui header">{{ trans("exams.unfortunately") }} !</h3>
                            <p>{{ trans("exams.you_have_failed") }}</p>
                            <div class="ui buttons eight wide column">
                                <button class="ui primary button result" @click="navigateToDashboard">{{
                                    trans("exams.go_to_dash") }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else>
            <div class="sixteen wide column">
                <div class="ui stackable grid" style="font-style: italic; text-align-last: end; align-items: center;">
                    <div class="three wide column">
                        <img src="https://studymock.com/assets/images/logo.svg" alt="Logo" class="ui medium image">
                    </div>
                    <div class="six wide column">
                        <h1 class="ui huge header">{{ testTitle }}</h1>
                    </div>
                </div>
                <div class="ui segment">
                    <h2 class="ui center aligned icon header test-failed">
                        <i class="times circle outline icon"></i>
                        {{ trans("exams.test_cheated") }}
                    </h2>
                    <div class="ui divider"></div>
                    <div class="ui segment">
                        <h3 class="ui header">{{ trans("exams.unfortunately") }} !</h3>
                        <p>{{ trans("exams.you_have_cheated") }}.</p>
                        <div class="ui buttons eight wide column">
                            <button class="ui primary button result" @click="navigateToDashboard">{{
                                trans("exams.go_to_dash") }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <v-dialog v-model="showPrevConfirmationDialog" persistent max-width="290">
            <v-card>
                <v-card-title class="headline">{{ trans("exams.confirmation") }}</v-card-title>
                <v-card-text>{{ trans("exams.are_you_sure_prev") }}.</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="showPrevConfirmationDialog = false">{{
                        trans("exams.cancel") }}</v-btn>
                    <v-btn color="blue darken-1" text @click="confirmPrevQuestion">{{ trans("exams.confirm") }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="showConfirmationDialog" persistent max-width="290">
            <v-card>
                <v-card-title class="headline">{{ trans("exams.confirmation") }}</v-card-title>
                <v-card-text>{{ trans("exams.are_you_sure_next") }}</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="showConfirmationDialog = false">{{ trans("exams.cancel")
                        }}</v-btn>
                    <v-btn color="blue darken-1" text @click="confirmNextQuestion">{{ trans("exams.confirm") }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="showSubmitConfirmationDialog" persistent max-width="290">
            <v-card>
                <v-card-title class="headline">{{ trans("exams.confirmation") }}</v-card-title>
                <v-card-text>{{ trans("exams.are_you_sure_submit") }}?</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancelSubmit">{{ trans("exams.cancel") }}</v-btn>
                    <v-btn color="blue darken-1" text @click="confirmSubmit">{{ trans("exams.confirm") }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <Toast ref="toast" />
    </div>
</template>


<script>
import { ref, reactive, computed, onMounted, onBeforeUnmount, watchEffect, watch } from 'vue';
import axios from 'axios';
import TimeInformation from './TimeInformation.vue';
import QuestionAnswers from './QuestionAnswers.vue';
import NavigationButtons from './NavigationButtons.vue';
import ToastService from 'primevue/toastservice';
import Toast from 'primevue/toast';

export default {
    name: "ExamContainer",
    components: {
        TimeInformation,
        QuestionAnswers,
        NavigationButtons,
        Toast
    },
    setup() {
        const windowCrossingPenaltiesNumber = ref(null);
        const windowAllowedCrossingDuration = ref(null);
        const mouseOverCount = ref(null);
        const lastMouseLeaveTime = ref(null);
        const totalMouseOverDuration = ref(null);
        const isMouseInside = ref(false);
        const isLoading = ref(false);
        const accessCode = ref('');
        const testId = ref('');
        const showSubmitConfirmationDialog = ref(false);
        const showConfirmationDialog = ref(false);
        const showPrevConfirmationDialog = ref(false);
        const userAnswers = reactive([]);
        const viewedQuestions = ref([]);
        const questions = ref([]);
        const expiredQuestions = ref([]);
        const currentQuestion = ref(1);
        const currentTimeRemaining = ref(0);
        const totalTestDurationRemaining = ref(null);
        const totalNumberQuestions = ref(0);
        const testDuration = ref(null);
        const passingScore = ref(0);
        const totalPointsTogether = ref(0);
        const totalPointsIndividual = ref(0);
        const totalTimeSpent = ref(testDuration.value - totalTestDurationRemaining.value);
        const timerInterval = ref(null);
        const timerTestInterval = ref(null);
        const testTitle = ref("");
        const userId = ref("");
        const userTestAttemptId = ref(null);
        const testSession = ref("");
        const email = ref("");
        const result = ref("");
        const passingMode = ref("");
        const isSubmitted = ref(false);
        const testCompleted = ref(false);
        const testFinished = ref(false);
        const isPassed = ref(false);
        const isCheated = ref(false);
        const checkIsCheated = ref(false);
        const startAt = ref(null);
        const endAt = ref(null);
        let intervalId = null;
        const toast = ref(null);

        const trans = (key) => {
            return window.trans(key);
        };

        const answeredQuestionsCount = computed(() => {
            return userAnswers.length;
        });

        const currentQuestionData = computed(() => {
            return questions.value[currentQuestion.value - 1] || {};
        });

        const filteredQuestions = computed(() => {
            return questions.value;
        });

        const numberQuestion = computed(() => {

            return questions.value.length;
        });

        const progressPercentage = computed(() => {
            if (filteredQuestions.value.length === 0) return 0;
            return Math.round(((answeredQuestionsCount.value) / filteredQuestions.value.length) * 100);
        });

        const isQuestionExpired = computed(() => {
            //return currentQuestionData.value.duration > 0 && (currentTimeRemaining.value === 0 || viewedQuestions.value.includes(currentQuestion.value));
        });

        const navigateToDashboard = () => {
            window.location.href = '/';
        };

        const handleMouseEnter = async () => {
            const penalties = windowCrossingPenaltiesNumber.value - mouseOverCount.value;
            if (!isMouseInside.value) {
                isMouseInside.value = true;
                if (lastMouseLeaveTime.value) {
                    const duration = Date.now() - lastMouseLeaveTime.value;
                    totalMouseOverDuration.value += duration;

                    if (penalties >= 0 && duration > windowAllowedCrossingDuration.value && mouseOverCount.value <= windowCrossingPenaltiesNumber.value && checkIsCheated.value === false) {
                        mouseOverCount.value++;
                        if (penalties > 0) {
                            toast.value.add({
                                severity: 'warn',
                                summary: 'Attention',
                                detail: `Please do not move outside the window boundaries. Your window will be closed after ${penalties} crossings.`,
                                life: 3000
                            });
                        }
                    }

                    if (mouseOverCount.value > windowCrossingPenaltiesNumber.value && checkIsCheated.value === false) {
                        isCheated.value = true;
                        checkIsCheated.value = true;
                        result.value = "Cheated";
                        confirmSubmit();
                    }

                    lastMouseLeaveTime.value = null;
                }
            }
        };

        const confirmSubmit = async () => {
            isLoading.value = true;
            checkIsCheated.value = true;
            showSubmitConfirmationDialog.value = false;

            try {
                const allAnswers = [];
                for (const [index, answer] of userAnswers.entries()) {
                    const question = filteredQuestions.value[index];
                    const userTestAttemptQuestionResponse = await axios.post('/api/user-test-attempts/questions', {
                        user_test_attempt_id: userTestAttemptId.value,
                        question_id: filteredQuestions.value[index].id
                    });

                    const userTestAttemptQuestionId = userTestAttemptQuestionResponse.data.data.id;

                    const answerId = question.answers?.[0]?.id || null;

                    if (typeof answer.value === 'object') {
                        for (const [key, val] of Object.entries(answer.value)) {
                            const answerData = {
                                user_test_attempt_question_id: userTestAttemptQuestionId,
                                question_id: filteredQuestions.value[index].id,
                                answer_id: parseInt(key, 10),
                                value: val !== undefined ? val.toString() : '',
                                points_earned: answer.points || null,
                                answered_at: answer.answered_at,
                            };

                            console.log('Submitting answer:', answerData);

                            const response = await axios.post('/api/user-test-attempt-question-answers', answerData);
                            console.log('Answer submitted successfully:', response);

                            allAnswers.push(answerData);
                        }
                    } else {
                        const answerData = {
                            user_test_attempt_question_id: userTestAttemptQuestionId,
                            question_id: filteredQuestions.value[index].id,
                            answer_id: answerId,
                            value: answer.value,
                            points_earned: answer.points || null,
                            answered_at: answer.answered_at,
                        };

                        console.log('Submitting answer:', answerData);

                        const response = await axios.post('/api/user-test-attempt-question-answers', answerData);
                        console.log('Answer submitted successfully:', response);

                        allAnswers.push(answerData);
                    }
                }

                let totalPoints = 0;

                if (passingMode.value === "TOGETHER") {
                    const response = await axios.get(`/getDate/${testSession.value}`);
                    console.log("data", response);
                    totalPointsTogether.value = calculateTotalPointsTogether(allAnswers, response);
                    totalPoints = totalPointsTogether.value;
                    console.log('Total points earned:', totalPointsTogether.value);
                } else {
                    totalPoints = calculateTotalPointsIndividual(allAnswers);
                    totalPointsIndividual.value = totalPoints;
                    console.log('Total points earned:', totalPoints);
                }

                if (result.value !== "Cheated") {
                    result.value = totalPoints > passingScore.value ? 'Passed' : 'Failed';
                    await axios.put(`/api/user-test-attempts/${userTestAttemptId.value}`, {
                        result: result.value,
                        end_at: new Date().toISOString()
                    });
                } else {
                    await axios.put(`/api/user-test-attempts/${userTestAttemptId.value}`, {
                        result: "Cheated",
                        end_at: new Date().toISOString()
                    });
                }

                console.log('Test result updated to:', result.value);

                isPassed.value = result.value === 'Passed';
                clearInterval(timerTestInterval.value);
                calculateTotalTimeSpent();
                isSubmitted.value = true;

            } catch (error) {
                console.error('Error submitting all answers:', error);
                if (error.response) {
                    console.log('Server response:', error.response.data);
                }
            } finally {
                isLoading.value = false;
            }
        };

        const findIndexByUserTestAttemptId = (array, user_test_attempt_question_id) => {
            for (let i = 0; i < array.length; i++) {
                if (array[i].user_test_attempt_question_id === user_test_attempt_question_id) {
                    return i;
                }
            }
            return -1;
        }
        
        const calculateTotalPointsTogether = (answers, response) => {
            let totalPoints = 0;
            const countedQuestions = new Set();

            const data = response.data;

            console.log('Response data:', data);

            if (!Array.isArray(filteredQuestions.value)) {
                console.error('filteredQuestions.value is not an array:', filteredQuestions.value);
                return totalPoints;
            }

            let arrayUserTestAttemptQuestionId = []

            answers.forEach(answer => {
                const questionId = answer.question_id;
                const question = filteredQuestions.value.find(q => q.id === questionId);

                console.log('Processing questionId:', questionId);
                console.log('Found question:', question);

                if (!question) {
                    console.error('Question not found for questionId:', questionId);
                    return;
                }

                const questionData = question.answers.find(ans => ans.id === answer.answer_id);

                console.log('Found questionData:', questionData);

                if (!questionData) {
                    console.error('Question data not found for answer_id:', answer.answer_id, 'in questionId:', questionId);
                    return;
                }

                if (answer.points_earned && !countedQuestions.has(questionId)) {
                    totalPoints += answer.points_earned;
                    countedQuestions.add(questionId);
                }

                console.log('Current totalPoints after adding answer points:', totalPoints);

                if (data.hasOwnProperty(answer.answer_id)) {
                    console.log(`Data found for answer_id: ${answer.answer_id}`, data[answer.answer_id]);

                    const sortedAnswers = data[answer.answer_id]
                        .filter(ans => ans.points_earned !== null)
                        .sort((a, b) => new Date(a.answered_at).getTime() - new Date(b.answered_at).getTime());

                    console.log('Sorted correct answers for answer_id:', answer.answer_id, sortedAnswers);

                    const bonusPoints = [
                        questionData.first_place_bonus || 0,
                        questionData.second_place_bonus || 0,
                        questionData.third_place_bonus || 0
                    ];
                    let ordre = 0;
                    console.log('Bonus points for answer_id:', answer.answer_id, bonusPoints);
                    ordre = findIndexByUserTestAttemptId(sortedAnswers, answer.user_test_attempt_question_id);
                    if (ordre in [0, 1, 2] && !arrayUserTestAttemptQuestionId.includes(answer.user_test_attempt_question_id)) {
                        totalPoints += bonusPoints[ordre];
                        console.log('Added bonus points:', bonusPoints[ordre], 'to totalPoints:', totalPoints);

                    }
                    arrayUserTestAttemptQuestionId.push(answer.user_test_attempt_question_id);
                } else {
                    console.log(`No data found for answer_id: ${answer.answer_id}`);
                }
            });

            console.log('Final totalPoints:', totalPoints);

            return totalPoints;
        };

        const calculateTotalPointsIndividual = (answers) => {
            let totalPoints = 0;
            const countedQuestions = new Set();

            answers.forEach(answer => {
                const questionId = answer.question_id;
                if (answer.points_earned && !countedQuestions.has(questionId)) {
                    totalPoints += answer.points_earned;
                    countedQuestions.add(questionId);
                }
            });

            return totalPoints;
        }

        const handleMouseLeave = () => {
            if (isMouseInside.value) {
                isMouseInside.value = false;
                lastMouseLeaveTime.value = Date.now();
            }
        };

        const startTimer = () => {
            currentTimeRemaining.value = currentQuestionData.value.duration;
            timerInterval.value = setInterval(() => {
                if (currentTimeRemaining.value > 0) {
                    currentTimeRemaining.value--;
                } else {
                    nextQuestion();
                    clearInterval(timerInterval.value);
                    //checkIfQuestionExpired();
                }
            }, 1000);
        };

        const prevQuestion = () => {
            if (currentTimeRemaining.value > 0) {
                showPrevConfirmationDialog.value = true;
            } else {
                proceedToPrevQuestion();
            }
        };

        const nextQuestion = () => {
            if (currentTimeRemaining.value > 0) {
                showConfirmationDialog.value = true;
            } else {
                startTimer();
                proceedToNextQuestion();
            }
        };

        const goToQuestion = (n) => {
            checkIfQuestionExpired();
            currentQuestion.value = n;
            if (currentQuestionData.value.duration > 0 && expiredQuestions.value.includes(currentQuestion.value)) {
                currentTimeRemaining.value = 0;
                clearInterval(timerInterval.value);
            }
        };

        const confirmPrevQuestion = () => {
            proceedToPrevQuestion();
            showPrevConfirmationDialog.value = false;
        };

        const proceedToPrevQuestion = () => {
            checkIfQuestionExpired();
            currentQuestion.value--;
            clearInterval(timerInterval.value);
            if (currentQuestionData.value.duration > 0 && !expiredQuestions.value.includes(currentQuestion.value)) {
                startTimer();
            } else {
                currentTimeRemaining.value = 0;
            }
        };

        const confirmNextQuestion = () => {
            proceedToNextQuestion();
            showConfirmationDialog.value = false;
        };

        const proceedToNextQuestion = () => {
            checkIfQuestionExpired();
            currentQuestion.value++;
            clearInterval(timerInterval.value);
            if (currentQuestionData.value.duration > 0 && !expiredQuestions.value.includes(currentQuestion.value)) {
                startTimer();
            } else {
                currentTimeRemaining.value = 0;
            }
        };

        const checkIfQuestionExpired = () => {
            if (currentTimeRemaining.value > 0) {
                expiredQuestions.value.push(currentQuestion.value);
            }
        };

        const formatTime = (time) => {
            if (!isNaN(time)) {
                const minutes = Math.floor(time / 60);
                const seconds = time % 60;
                return `${minutes}:${seconds.toString().padStart(2, '0')}`;
            }
            return '';
        };

        const handleUpdateTextAnswer = ({ questionIndex, answer }) => {
            userAnswers[questionIndex] = answer;
        };

        const handleUpdateChoicesOrder = ({ questionIndex, answer }) => {
            userAnswers[questionIndex] = answer;
        };

        const handleSelectAnswer = ({ questionIndex, answer }) => {
            userAnswers[questionIndex] = answer;
        };

        const handleUploadAttachment = ({ questionIndex, answer }) => {
            userAnswers[questionIndex] = answer;
        };

        const calculateTotalTimeSpent = () => {
            totalTimeSpent.value = testDuration.value - totalTestDurationRemaining.value;
        }

        const startCountdown = () => {
            timerTestInterval.value = setInterval(() => {
                if (totalTestDurationRemaining.value > 0) {
                    totalTimeSpent.value = testDuration.value - totalTestDurationRemaining.value;
                    totalTestDurationRemaining.value--;
                }
                else {
                    if (isCheated.value === false && checkIsCheated.value === false) {
                        confirmSubmit();
                        clearInterval(timerTestInterval.value);
                        testFinished.value = true;
                        endAt.value = new Date().toISOString();
                    }
                }
            }, 1000);
        };

        const loadQuestions = async () => {
            try {
                const response = await axios.get(`/api/exam/${testId.value}`);
                const testData = response.data;
                windowCrossingPenaltiesNumber.value = testData.window_crossing_penalties_number
                windowAllowedCrossingDuration.value = testData.window_allowed_crossing_duration
                testSession.value = testData.test_session[0].id;
                passingMode.value = testData.test_session[0].passing_mode;
                console.log(passingMode.value);
                userId.value = testData.created_by_user_id;
                testTitle.value = testData.title;

                questions.value = testData.questions.map(question => ({
                    ...question,
                    duration: parseInt(question.duration, 10)
                }));

                totalTestDurationRemaining.value = parseInt(testData.duration, 10);
                testDuration.value = parseInt(testData.duration, 10);
                passingScore.value = testData.passing_score;
                result.value = 'Failed';

                startAt.value = new Date().toISOString();

                const invitations = testData.test_session[0].invitations;
                const invitation = invitations.find(invitation => invitation.access_code === accessCode.value);
                email.value = invitation.email;
                await axios.put(`/api/update-is-code-used/${invitation.id}`);

                if (invitation) {
                    console.log('Id found:', invitation.id);
                    console.log('Email found:', invitation.email);
                } else {
                    console.log('No email found for access code:', accessCode.value);
                }

                const testAttemptResponse = await axios.post('/api/user-test-attempts', {
                    test_session_id: testSession.value,
                    user_id: userId.value,
                    start_at: new Date().toISOString(),
                    result: result.value,
                    recorded_camera_video_path: "path/to/video.mp4",
                    recorded_audio_path: "path/to/audio.mp3"
                });

                result.value = 'In Progress';
                userTestAttemptId.value = testAttemptResponse.data.data.id;
                console.log('User Test Attempt ID:', userTestAttemptId.value);

            } catch (error) {
                console.error('Error loading questions:', error);
            }
        };

        const cancelSubmit = () => {
            showSubmitConfirmationDialog.value = false;
        };

        const submitAllAnswers = () => {
            showSubmitConfirmationDialog.value = true;
        };

        const emitExamUpdatedEvent = async () => {
            try {
                const response = await axios.get('/exam-event', {
                    params: {
                        examId: testId.value,
                        userTestAttemptId: userTestAttemptId.value,
                        totalTimeSpent: totalTimeSpent.value,
                        answeredQuestionsCount: answeredQuestionsCount.value,
                        totalTimeRemaining: totalTestDurationRemaining.value,
                        status: result.value,
                        nombreOfQuestion: totalNumberQuestions.value,
                        userEmail: email.value,
                        totalPoints: totalPointsTogether.value || totalPointsIndividual.value,
                    }
                });
                console.log('Event emitted successfully');
            } catch (error) {
                console.error('Error emitting event:', error);
            }
        };

        const startTimers = () => {
            intervalId = setInterval(() => {
                emitExamUpdatedEvent();
            }, 1000);
        };

        onMounted(async () => {
            const params = new URLSearchParams(window.location.search);
            accessCode.value = params.get('accessCode');
            const testIdResponse = await axios.get(`/test-by-access-code/${accessCode.value}`);
            testId.value = testIdResponse.data.test_id;
            await loadQuestions();
            startCountdown();
            startTimer();
            startTimers();
            totalNumberQuestions.value = questions.value.length;
            emitExamUpdatedEvent();
        });

        onBeforeUnmount(() => {
            clearInterval(timerTestInterval.value);
            clearInterval(timerInterval.value);
        });

        return {
            trans,
            testFinished,
            isPassed,
            isCheated,
            isLoading,
            showConfirmationDialog,
            showPrevConfirmationDialog,
            showSubmitConfirmationDialog,
            confirmSubmit,
            cancelSubmit,
            testTitle,
            questions,
            userAnswers,
            numberQuestion,
            expiredQuestions,
            currentQuestion,
            currentQuestionData,
            mouseOverCount,
            currentTimeRemaining,
            totalTestDurationRemaining,
            totalTimeSpent,
            answeredQuestionsCount,
            filteredQuestions,
            progressPercentage,
            isQuestionExpired,
            prevQuestion,
            nextQuestion,
            confirmPrevQuestion,
            confirmNextQuestion,
            proceedToPrevQuestion,
            proceedToNextQuestion,
            goToQuestion,
            checkIfQuestionExpired,
            formatTime,
            handleUpdateTextAnswer,
            handleUpdateChoicesOrder,
            handleSelectAnswer,
            handleUploadAttachment,
            isSubmitted,
            testCompleted,
            startTimer,
            submitAnswer: submitAllAnswers,
            navigateToDashboard,
            userTestAttemptId,
            testDuration,
            email,
            result,
            testId,
            totalNumberQuestions,
            accessCode,
            testId,
            passingMode,
            handleMouseLeave,
            handleMouseEnter,
            lastMouseLeaveTime,
            totalMouseOverDuration,
            windowCrossingPenaltiesNumber,
            windowAllowedCrossingDuration,
            toast,
            checkIsCheated,
            totalPointsTogether,
            totalPointsIndividual,
        };
    },
};

</script>

<style scoped>
.ui.container {
    padding: 20px;
}

.flashing-red {
    color: red !important;
    animation: blink-animation 1s steps(5, start) infinite !important;
}

@keyframes blink-animation {
    to {
        visibility: hidden;
    }
}

.total-time-spent {
    text-align: end !important;
}

.ui.primary.button.result {
    background-color: var(--project-primary-color) !important;
}

.ui.primary.button.result:hover {
    background-color: #344934 !important;
}

.test-complete {
    color: var(--project-primary-color) !important;
}

.test-failed {
    color: red !important;
}

.ui.active.inverted.dimmer {
    background-color: white !important;
}
</style>
