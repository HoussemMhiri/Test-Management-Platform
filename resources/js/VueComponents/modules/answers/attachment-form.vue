<template>
    <div class="ui form">
        <div class="inline field">
            <label>{{ trans("questions.choose_response_file") }}</label>
            <input @change="updateFile" type="file">
        </div>
    </div>
</template>

<script>
export default {
    name: "attachment-form",
    props: {
        modelAnswerValue: Object,
        index: Number,
        answer_file_url: String,
    },
    methods: {
        trans(key) {
            return trans(key);
        },
        updateFile(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = event => {
                    const fileUrl = event.target.result;
                    this.$emit('update:answer_file_url', fileUrl);
                    this.$emit('update:modelAnswerValue', {
                        ...this.modelAnswerValue,
                        answer_file_url: fileUrl
                    });
                };
                reader.readAsDataURL(file);
            }
        }
    }
};
</script>

<style>
.ui.form .text {
    border: none !important;
}

input:focus {
    border: 1px solid var(--project-primary-color) !important;
}
</style>
