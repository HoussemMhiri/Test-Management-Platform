<template>
    <tr>
        <td class="true_false">
            <i class="icon checkmark circle-icon" :class="[answer.correct ? 'checked' : 'unchecked']"
                style="cursor: pointer;" @click="toggleCorrect"></i>
                <!-- <i class="circle icon circle-icon" :class="[answer.correct ? 'checked' : 'unchecked']"
                style="cursor: pointer;" @click="toggleCorrect"></i> -->
        </td>
        <td>
            <input v-model="answer.text" type="text" class="form-control">
        </td>
        <td>
            <input v-model="answer.points" type="number" class="form-control">
        </td>
        <td>
            <div class="answer_actions">
                <i class="arrow up icon" @click="$emit('move-up')"></i>
                <i class="arrow down icon" @click="$emit('move-down')"></i>
                <i class="delete icon red" @click="$emit('delete')"></i>
            </div>
        </td>
    </tr>
</template>

<script>
export default {
    name: "choice-selection",
    props: {
        modelAnswerValue: Object,
        index: Number,
        answerCount: Number
    },
    computed: {
        answer: {
            get() {
                return this.modelAnswerValue;
            },
            set(value) {
                this.$emit('update:modelAnswerValue', value);
            }
        }
    },
    methods: {
        toggleCorrect() {
            this.answer.correct = !this.answer.correct;
        },
    },

};
</script>

<style scoped>
.checked {
    color: var(--project-primary-color);
}

.unchecked {
    color: #ada5a5;
}

.circle-icon {
    font-size: large;
}

.arrow {
    cursor: pointer;
    color: var(--project-primary-color);
    font-size: 15px;
}

.enter_text,
.enter_point {
    background-color: #EFEFEF !important;
}

.answer_actions {
    display: flex;
    justify-content: space-between;
}

.true_false {
    text-align: center !important;
}
.delete.icon.red{
    cursor: pointer;
}

input:focus {
    border: 1px solid var(--project-primary-color) !important;
}
</style>
