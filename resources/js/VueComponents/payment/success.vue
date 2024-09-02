<template>
    <div class="all_container">
        <div class="all_code_container">
            <div class="first_container">
                <img src="/images/payment/pay3.jpg" class="img" />
                <h2>
                    {{ trans("payment_success.h2") }}
                    <span style="color: var(--project-primary-color)">{{
                        plan.name
                    }}</span>
                    {{ trans("payment_success.tier") }}.
                </h2>
                <p class="p">{{ trans("payment_success.p") }}.</p>
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
import Btn from "../modules/tests/tests-components/btn.vue";
export default {
    name: "success",

    components: { Btn },

    data() {
        return {
            plan: "",
            id: "",
        };
    },

    methods: {
        trans(key) {
            return trans(key);
        },
        async getOnePlan() {
            const { data } = await axios.get(`/api/plans/${this.id}`);
            console.log(data);

            this.plan = data?.data;
        },

        getIdFromUrl() {
            const pathArray = window.location.pathname.split("/");
            return pathArray[2];
        },
    },

    created() {
        this.id = this.getIdFromUrl();
    },

    mounted() {
        if (this.id) {
            this.getOnePlan();
        }
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
