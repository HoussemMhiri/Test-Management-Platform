<template>
    <tr>
        <td>
            <input v-model="answer.order" type="number" placeholder="" class="order-input">
        </td>
        <td>
            <input v-model="answer.text" type="text" placeholder="Enter answer text" class="enter_text">
        </td>
        <td>
            <input v-model="answer.points" type="number" placeholder="Enter points" class="enter_point">
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
    name: "choice-ordering-form",
    props: {
        modelAnswerValue: Object,
        index: Number,
        answerCount: Number,
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
};
</script>

<style scoped>
.fields {
    margin-top: 10px !important;
    align-items: center !important;
}

.checked {
    color: var(--project-primary-color);
}

.unchecked {
    color: #ada5a5;
}

.arrow {
    cursor: pointer;
    color: var(--project-primary-color);
    font-size: 15px;
}

.order-input {
    width: 54px !important;
}

.order-input,
.enter_text,
.enter_point {
    background-color: #EFEFEF !important;
}
.answer_actions {
    display: flex;
    justify-content: space-between;
}

.delete.icon.red{
    cursor: pointer;
}

input:focus {
    border: 1px solid var(--project-primary-color) !important;
}
</style>
