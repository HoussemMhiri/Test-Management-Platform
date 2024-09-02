<template>
    <div class="item item_container">
        <div class="image">
            <img src="/images/payment/plan.jpg" class="TestSession_img" />
        </div>
        <div class="content">
            <div class="header">{{ plan.name }}</div>
            <div class="description">
                <div>
                    <p class="span_title">
                        {{ trans("subscription_plans.description") }}:
                    </p>
                    <span class="limited-text">{{ plan.description }}</span>
                </div>
                <div>
                    <span class="span_title"
                        >{{ trans("subscription_plans.monthly") }}:</span
                    >
                    <span class="">{{ formatPrice(plan.monthly_price) }}$</span>
                </div>
                <div>
                    <span class="span_title"
                        >{{ trans("subscription_plans.type") }}:</span
                    >
                    <span class="">{{ plan.plan_limitation_type }}</span>
                </div>
                <div v-if="plan.plan_limitation_type === 'Number'">
                    <span class="span_title"
                        >{{ trans("subscription_plans.max") }}:</span
                    >
                    <span class="">{{ plan.max_templates_number }}</span>
                </div>
            </div>
            <div class="extra">
                <div class="ui right floated">
                    <btn
                        :text="trans('tests.edit')"
                        :bgColor="'#00b16e'"
                        :textColor="'white'"
                        :cls="'acc btn'"
                        :font_Weight="'600'"
                        @click="getOnePlan"
                    />
                    <btn
                        :text="trans('tests.delete')"
                        :bgColor="'#ff4242'"
                        :textColor="'white'"
                        :cls="'rej btn'"
                        :font_Weight="'600'"
                        @click="deletePlan"
                    />
                </div>
            </div>
            <label-component
                :cls="'ui top right attached label'"
                :text="plan.name"
                :font_size="'15px'"
                :bgColor="[
                    plan.name === 'Basic'
                        ? '#00b5ad'
                        : plan.name === 'Standard'
                        ? '#2185d0'
                        : '#db2828',
                ]"
                :textColor="'white'"
                :btn_width="'118px'"
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Btn from "../modules/tests/tests-components/btn.vue";
import LabelComponent from "../modules/tests/tests-components/label-component.vue";
export default {
    name: "plan-card",

    components: { Btn, LabelComponent },

    props: ["switchScreen", "plan", "fetchAllPlans"],

    emits: ["getThePlan", "loading"],

    data() {
        return {
            isLoading: false,
        };
    },

    methods: {
        trans(key) {
            return trans(key);
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
        updateLoading() {
            this.$emit("loading", this.isLoading);
        },
        async deletePlan() {
            swal.fire({
                title: trans("common.are_you_sure"),
                text: trans("common.revert_back_is_impossible"),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4481eb",
                cancelButtonColor: "#d33",
                confirmButtonText: trans("common.confirm"),
                cancelButtonText: trans("common.cancel"),
            }).then((result) => {
                if (result.isConfirmed) {
                    this.isLoading = true;
                    this.updateLoading();

                    axios
                        .delete(`/api/plans/${this.plan.id}/destroy`)
                        .then((response) => {
                            return new Promise((res) => {
                                setTimeout(() => {
                                    this.fetchAllPlans();
                                    this.isLoading = false;
                                    this.updateLoading();
                                    res();
                                }, 500);
                            });
                        })
                        .then(() => {
                            toast.fire({
                                icon: "success",
                                title: trans("subscription_plans.delete"),
                                timer: 2000,
                            });
                        })
                        .catch((error) => {
                            this.isLoading = false;
                            handleLaravelAxiosErrorResponse(error);
                        });
                }
            });
        },

        async getOnePlan() {
            const { data } = await axios.get(`/api/plans/${this.plan.id}`);
            console.log(data.data);
            this.switchScreen("edit");
            this.$emit("getThePlan", data.data);
        },
    },
};
</script>

<style scoped>
.limited-text {
    display: inline-block;
    max-width: 50%;
}
.item_container {
    background-color: white !important;
    width: 100% !important;
    border: 1px solid transparent !important;
    cursor: pointer;
    padding: 20px 10px 10px 20px !important;
    position: relative;
}
.item_container:hover {
    border: 1px solid var(--project-primary-color) !important;
}

.header {
    font-size: 25px !important;
    color: var(--project-primary-color) !important;
}

.TestSession_img {
    width: 200px !important;
    object-fit: cover;
}

.content {
    margin-left: 30px !important;
}

.description span {
    font-size: 15px !important;
}
.description div {
    margin: 10px 0;
}
.span_title {
    margin-right: 10px !important;
    font-size: 16px !important;
    font-weight: bold;
}

.btn {
    width: 80px;
    margin-right: 10px !important;
    border: none;
    margin-top: 10px;
}

.rej:hover {
    transition: all 0.2s ease;
    background-color: white !important;
    border: 1px solid #ff4242;
    color: black !important;
}
.acc:hover {
    transition: all 0.2s ease;
    background-color: white !important;
    border: 1px solid var(--project-primary-color);
    color: black !important;
}
</style>
