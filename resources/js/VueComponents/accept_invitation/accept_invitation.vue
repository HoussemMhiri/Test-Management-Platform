<template>
    <div class="all_container">
        <div class="all_code_container">
            <div class="first_container">
                <img
                    src="images/accept_invitation/accepted.jpg"
                    alt="Enter Code"
                    class="img"
                />
                <h2>{{ trans("accept_invitation.successMsg") }}.</h2>
                <p class="p">{{ trans("accept_invitation.successMsgPT2") }}!</p>
            </div>
            <div class="centered-content">
                <div class="confirm_btn">
                    <a href="/app"
                        ><btn
                            :text="trans('accept_invitation.dashboard')"
                            :bgColor="'#00b16e'"
                            :textColor="'white'"
                            :cls="'acc btn_c'"
                            :font_Weight="'600'"
                        />
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VOtpInput from "vue3-otp-input";
import Btn from "../modules/tests/tests-components/btn.vue";
export default {
    name: "accept_invitation",

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
h2,
p {
    text-align: center;
}
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

.confirm_btn a {
    margin: 0 10px;
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
