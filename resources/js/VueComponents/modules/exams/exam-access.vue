<template>
    <div class="ui container">
        <div class="ui two column grid stackable">
            <div class="column">
                <div class="ui raised segment">
                    <div class="ui list">
                        <div class="item">
                            <i class="info circle icon large teal"></i>
                            <div class="content">
                                <h1 class="ui header">{{ title }}</h1>
                                <div class="ui sub header">{{ trans("exams.test_details") }}</div>
                                <div class="description" v-html="formatDescription(description)"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="ui raised segment center aligned">
                    <h2 class="ui header">{{ trans("exams.test_time_starts") }}</h2>
                    <div class="ui large teal label" id="timer">{{ formattedRemainingTime }}</div>
                </div>
            </div>
        </div>
        <div class="ui centered grid">
            <div class="eight wide column">
                <div class="ui raised segment">
                    <div class="ui action input fluid">
                        <input type="text" placeholder="Access Code" v-model="accessCode">
                        <div v-if="passingMode === 'INDIVIDUAL'">
                            <button @click="goToTest" class="ui primary button fluid"
                                :disabled="formattedRemainingTime !== '0 days 00:00:00'">
                                {{ trans("exams.go_to_test") }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Toast />
    </div>
</template>

<script>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';
import axios from 'axios';
import { useToast } from 'primevue/usetoast';

export default {
    name: "ExamAccess",
    setup() {
        const description = ref('');
        const passingMode = ref('');
        const title = ref('');
        const accessCode = ref('');
        const testId = ref('');
        const testSessions = ref([]);
        const isCodeUsed = ref(false);
        const startAt = ref('');
        const formattedRemainingTime = ref('');
        const dateFormatee = ref('');
        const tempsFormate = ref('');
        const intervalId = ref(null);
        const toast = useToast();

        const trans = (key) => {
            return window.trans(key);
        };

        const loadQuestions = async () => {
            try {
                const response = await axios.get(`/api/exam/1`);
                const testData = response.data;
                console.log(testData);
                title.value = testData.title;
                description.value = testData.description;
                startAt.value = testData.start_at;
                testSessions.value = testData.test_session;
                passingMode.value = testSessions.value[0].passing_mode
                const dateActuelle = new Date();
                const jour = dateActuelle.getDate();
                const mois = dateActuelle.getMonth() + 1;
                const annee = dateActuelle.getFullYear();

                dateFormatee.value = `${mois}/${jour}/${annee}`;
                const hours = dateActuelle.getHours();
                const minutes = dateActuelle.getMinutes();
                const seconds = dateActuelle.getSeconds();

                tempsFormate.value = `${hours}:${minutes}:${seconds}`;
                formattedRemainingTime.value = tempsRestant(startAt.value, dateFormatee.value, tempsFormate.value);
                console.log(formattedRemainingTime.value);
                decrementTime(formattedRemainingTime.value);
            } catch (error) {
                console.error('Error loading questions:', error);
            }
        };

        const decrementTime = (duration) => {
            let days = 0, hours = 0, minutes = 0, seconds = 0;

            let matches = duration.match(/(\d+) days (\d+):(\d+):(\d+)/);
            if (matches && matches.length === 5) {
                days = parseInt(matches[1], 10);
                hours = parseInt(matches[2], 10);
                minutes = parseInt(matches[3], 10); 
                seconds = parseInt(matches[4], 10);
            } else {
                matches = duration.match(/(\d+):(\d+):(\d+)/);
                if (matches && matches.length === 4) {
                    hours = parseInt(matches[1], 10);
                    minutes = parseInt(matches[2], 10);
                    seconds = parseInt(matches[3], 10);
                } else {
                    return;
                }
            }

            let totalSeconds = days * 24 * 60 * 60 + hours * 60 * 60 + minutes * 60 + seconds;

            const intervalId = setInterval(() => {
                days = Math.floor(totalSeconds / (24 * 60 * 60));
                let remainingSeconds = totalSeconds % (24 * 60 * 60);
                hours = Math.floor(remainingSeconds / (60 * 60));
                remainingSeconds %= (60 * 60);
                minutes = Math.floor(remainingSeconds / 60);
                seconds = remainingSeconds % 60;

                formattedRemainingTime.value = `${days} days ${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                console.log(`${days} days ${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`);

                totalSeconds--;

                if (totalSeconds < 0) {
                    clearInterval(intervalId);
                    console.log("Temps écoulé !");
                }
            }, 1000);

            return intervalId;
        };

        const tempsRestant = (dateLimite, dateActuelle, heureActuelle) => {
            const dateLimiteObj = new Date(dateLimite);
            const dateActuelleObj = new Date(dateActuelle + ' ' + heureActuelle);

            const difference = dateLimiteObj - dateActuelleObj;

            let days = Math.floor(difference / (1000 * 60 * 60 * 24));
            let hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((difference % (1000 * 60)) / 1000);

            let formattedTime = '';
            if (days > 0) {
                formattedTime += days + ' days ';
            }
            formattedTime += `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            return formattedTime;
        };

        const checkAccessCode = (code) => {
            for (let session of testSessions.value) {
                for (let invitation of session.invitations) {
                    if (invitation.access_code === code && invitation.is_code_used === 0 && invitation.status === "ACCEPTED") {
                        return true;
                    }
                }
            }
            return false;
        };

        const goToTest = async () => {
            if (checkAccessCode(accessCode.value)) {
                try {
                    isCodeUsed.value = true;
                    window.location.href = `/exam?accessCode=${accessCode.value}`;
                } catch (error) {
                    console.error('Error updating is_code_used:', error);
                }
            } else {
                toast.add({ severity: 'error', summary: 'Invalid Access Code', detail: 'The access code you entered is invalid.', life: 3000 });
            }
        };
        const formatDescription = (description) => {
            if (!description) return '';
            const words = description.split(' ');
            const formattedWords = words.reduce((acc, word, index) => {
                if ((index + 1) % 7 === 0) {
                    acc += word + '<br>';
                } else {
                    acc += word + ' ';
                }
                return acc;
            }, '');
            return formattedWords.trim();
        };

        watch([passingMode, formattedRemainingTime], ([newPassingMode, newFormattedRemainingTime]) => {
            if (newPassingMode === 'TOGETHER' && newFormattedRemainingTime === '0 days 00:00:00') {
                if (checkAccessCode(accessCode.value)) {
                    isCodeUsed.value = true;
                    window.location.href = `/exam?accessCode=${accessCode.value}`;
                }
                else {
                    toast.add({ severity: 'error', summary: 'Invalid Access Code', detail: 'The access code you entered is invalid.', life: 3000 });
                }
            }

        });

        onMounted(async () => {
            await loadQuestions();
        });

        onBeforeUnmount(() => {
            clearInterval(intervalId.value);
        });

        return {
            trans,
            formattedRemainingTime,
            title,
            description,
            accessCode,
            testId,
            goToTest,
            isCodeUsed,
            tempsFormate,
            dateFormatee,
            formatDescription,
            passingMode
        };
    }
};
</script>

<style scoped>
.ui.container {
    margin-top: 40px;
}

.ui.raised.segment {
    padding: 20px;
    transition: box-shadow 0.3s ease;
}

.ui.raised.segment:hover {
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
}

.ui.large.teal.label {
    font-size: 1.5em;
    padding: 10px 15px;
    transition: background-color 0.3s ease;
}

.ui.large.teal.label:hover {
    background-color: var(--project-primary-color);
}

.ui.action.input>input {
    width: calc(100% - 100px);
    /* Adjusted width to ensure proper button alignment */
}

.ui.primary.button {
    width: 100px;
    /* Fixed width to maintain consistent button size */
    margin-left: 10px;
    transition: background-color 0.3s ease;
}

.ui.primary.button:hover {
    background-color: var(--project-primary-color);
}

.description {
    white-space: pre-line;
}

.ui.center.aligned.segment {
    text-align: center;
}
</style>
