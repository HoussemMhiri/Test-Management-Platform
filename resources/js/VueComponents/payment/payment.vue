<template>
    <div class="all_container">
        <h1 class="ui center aligned header">Checkout</h1>
        <div class="ui grid stackable">
            <div class="eight wide column">
                <div class="ui segment">
                    <h2>{{ trans("payment_success.card_info") }}</h2>
                    <div class="ui large form">
                        <div class="field">
                            <label>{{
                                trans("payment_success.card_num")
                            }}</label>
                            <input
                                type="text"
                                :placeholder="trans('payment_success.card_num')"
                            />
                        </div>
                        <div class="fields">
                            <div class="eight wide field">
                                <label>{{
                                    trans("payment_success.expiry_date")
                                }}</label>
                                <input type="text" placeholder="MM/YY" />
                            </div>
                            <div class="eight wide field">
                                <label>{{
                                    trans("payment_success.cvv")
                                }}</label>
                                <input type="text" placeholder="CVV" />
                            </div>
                        </div>
                        <div class="field">
                            <label>{{
                                trans("payment_success.card_holder")
                            }}</label>
                            <input
                                type="text"
                                :placeholder="
                                    trans('payment_success.card_holder')
                                "
                            />
                        </div>
                    </div>
                    <div class="extra content">
                        <btn
                            :text="trans('payment_success.pay_now')"
                            :bgColor="'#00b16e'"
                            :textColor="'white'"
                            :cls="'acc btn_c'"
                            :font_Weight="'600'"
                            @click="updatePlan"
                        />
                    </div>
                </div>
            </div>
            <div class="eight wide column">
                <div class="ui segment">
                    <h2>{{ trans("payment_success.plan_details") }}</h2>
                    <div class="ui card">
                        <div class="image">
                            <img
                                src="/images/payment/pay6.jpg"
                                alt="Product Image"
                            />
                        </div>
                        <div class="content">
                            <div class="plan_cont">
                                <span
                                    >{{
                                        trans("subscription_plans.plan_name")
                                    }}:
                                </span>
                                <span class="plan_name">{{ plan.name }}</span>
                            </div>

                            <span
                                >${{ formatPrice(plan.monthly_price) }}/{{
                                    trans("upgrade_plans.month")
                                }}</span
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="confirm_btn">
            <a href="/upgrade_plans"
                ><btn
                    :text="trans('payment_success.plans')"
                    :bgColor="'white'"
                    :textColor="'#00b16e'"
                    :cls="'acc btn_c'"
                    :font_Weight="'600'"
                />
            </a>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import btn from "../modules/tests/tests-components/btn.vue";

export default {
    components: { btn },
    name: "payment",

    data() {
        return {
            id: "",
            plan: "",
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

        formatPrice(price) {
            const priceNumber = parseFloat(price);

            if (!isNaN(priceNumber)) {
                if (priceNumber % 1 === 0) {
                    return priceNumber.toFixed(0);
                }
                return priceNumber.toFixed(2);
            }
            return price;
        },

        async updatePlan() {
            try {
                const { data } = await axios.put(
                    `/api/payment/${this.id}/update`
                );
                window.location.href = `/payment/${data?.subscriptionPlanId}/success`;
            } catch (error) {
                console.log(error);
            }
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
input:hover,
input:focus {
    border: 1px solid var(--project-primary-color) !important;
}
.all_container {
    background-color: #3bcd88;
    min-height: 100vh;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

h1 {
    color: white !important;
    font-size: 40px !important;
    margin-bottom: 20px;
}

.plan_cont {
    margin: 10px 0;
}

span {
    font-weight: 600;
    font-size: 16px;
}

.plan_name {
    color: var(--project-primary-color);
}

.ui.grid {
    width: 80%;
}

.ui.segment {
    background: white;
}

.ui.card {
    width: 100%;
}

.image {
    width: 100%;
    height: 300px;
    position: relative;
    overflow: hidden;
}

.image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.btn_c {
    margin-top: 20px;
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
</style>
