<template>
    <div class="all_container">
        <div class="all_code_container">
            <div class="first_container">
                <img
                    src="images/access_code/enter_code.jpg"
                    alt="Enter Code"
                    class="img"
                />
                <h1>{{ trans("access_code.enter") }}</h1>
                <p class="p">
                    {{ trans("access_code.reminder") }}
                </p>
            </div>
            <div class="centered-content">
                <div class="ui form">
                    <div class="fields">
                        <div class="field">
                            <v-otp-input
                                ref="otpInput"
                                input-classes="otp-input"
                                :conditionalClass="[
                                    'one',
                                    'two',
                                    'three',
                                    'four',
                                    'five',
                                ]"
                                separator="-"
                                inputType="letter-numeric"
                                :num-inputs="5"
                                v-model:value="bindValue"
                                :should-auto-focus="true"
                                :should-focus-order="true"
                                @on-change="handleOnChange"
                                @on-complete="handleOnComplete"
                                :placeholder="['*', '*', '*', '*', '*']"
                            />
                        </div>
                        <div class="field">
                            <btn
                                @click="clearInput"
                                :text="trans('access_code.clear_input')"
                                :bgColor="'#00b16e'"
                                :textColor="'white'"
                                :cls="'acc btn'"
                                :font_Weight="'600'"
                            />
                        </div>
                    </div>
                </div>
                <div class="confirm_btn">
                    <btn
                        :text="trans('common.confirm')"
                        :bgColor="'#00b16e'"
                        :textColor="'white'"
                        :cls="'acc btn_c'"
                        :font_Weight="'600'"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VOtpInput from "vue3-otp-input";
import Btn from "../modules/tests/tests-components/btn.vue";
export default {
    name: "access_code",

    components: { VOtpInput, Btn },

    data() {
        return {
            bindValue: "",
        };
    },

    methods: {
        trans(key) {
            return trans(key);
        },

        handleOnComplete(value) {
            console.log("OTP completed: ", value);
        },
        handleOnChange(value) {
            console.log("OTP changed: ", value);
        },
        clearInput() {
            this.$refs.otpInput.clearInput();
        },
        fillInput(value) {
            console.log(value);
            this.$refs.otpInput.fillInput(value);
        },
    },
};
</script>

<style scoped>
.all_container {
    background-color: #3bcd88;
    height: 100vh;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.all_code_container {
    background-color: white;
    box-shadow: 0 2px 4px rgba(0, 177, 110, 0.5);
    border-radius: 5px;
    padding: 30px;
    width: 100%;
    max-width: 750px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.img {
    width: 250px;
    height: 250px;
    border-radius: 50%;
    object-fit: contain;
}
.first_container {
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.btn {
    width: 100px;
    border: none;
}

.btn_c {
    width: 150px;
    border: none;
    letter-spacing: 0.6px;
}
.acc:hover {
    transition: all 0.2s ease;
    background-color: white !important;
    border: 1px solid var(--project-primary-color);
    color: black !important;
}

.confirm_btn {
    margin-top: 20px;
    text-align: center;
}

.p {
    color: gray;
    font-size: 16px;
    letter-spacing: 0.3px;
}

.centered-content {
    text-align: center;
}
</style>
<style>
.otp-input {
    width: 40px !important;
    height: 40px !important;
    padding: 5px !important;
    margin: 0 10px !important;
    font-size: 20px !important;
    border-radius: 4px !important;
    text-align: center;
}
.otp-input:focus {
    border: 2px solid var(--project-primary-color) !important;
}

.otp-input.is-complete {
    background-color: var(--project-primary-color) !important;
    color: white !important;
}

.otp-input::-webkit-inner-spin-button,
.otp-input::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input::placeholder {
    font-size: 15px;
    text-align: center;
    font-weight: 600;
}
</style>
