<template>
    <input v-model="text" type="text" placeholder="Write some text here" class="text-input">
</template>

<script>
export default {
    name: "text-form",
    props: {
        modelAnswerValue: Object,
    },
    computed: {
        text: {
            get() {
                return this.modelAnswerValue.text;
            },
            set(newText) {
                this.$emit('update:modelAnswerValue', {
                    ...this.modelAnswerValue,
                    text: newText
                });
            }
        }
    }
};
</script>

<style scoped>

.text-input {
  margin-top: 10px !important;
  width: 100% !important;
  padding: 0.5rem !important;
  font-size: 1rem !important;
  border: 1px solid #ccc !important;
  border-radius: 0.25rem !important;
  transition: border-color 0.2s ease !important;
}

.text-input:focus {
    border: 1px solid var(--project-primary-color) !important;
}

</style>
