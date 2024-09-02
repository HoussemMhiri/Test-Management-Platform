<template>
    <form
        @submit.prevent="this.screenName === 'edit' ? updatePlan() : addPlan()"
        class="ui equal width large form form_container"
    >
        <h1>{{ trans("subscription_plans.title") }}</h1>
        <div class="fields names_field">
            <div class="field">
                <label> {{ trans("subscription_plans.plan_name") }} </label>
                <input
                    v-model="form.name"
                    type="text"
                    :placeholder="trans('subscription_plans.plan_name')"
                />
            </div>

            <div class="field">
                <label> {{ trans("subscription_plans.features") }} </label>
                <input
                    v-model="form.features"
                    type="text"
                    :placeholder="trans('subscription_plans.features')"
                />
            </div>
        </div>
        <div class="fields">
            <div class="field">
                <label> {{ trans("subscription_plans.description") }} </label>
                <textarea
                    v-model="form.description"
                    :placeholder="trans('subscription_plans.description')"
                ></textarea>
            </div>
        </div>
        <div class="fields">
            <div class="field">
                <label>{{ trans("subscription_plans.annual") }}</label>
                <input
                    v-model="form.annual_price"
                    type="number"
                    :placeholder="trans('subscription_plans.annual')"
                />
            </div>

            <div class="field">
                <label>{{ trans("subscription_plans.monthly") }}</label>
                <input
                    v-model="form.monthly_price"
                    type="number"
                    :placeholder="trans('subscription_plans.monthly')"
                />
            </div>

            <div class="field">
                <label>{{ trans("subscription_plans.individual") }} </label>
                <input
                    v-model="form.individual_template_price"
                    type="number"
                    :placeholder="trans('subscription_plans.individual')"
                />
            </div>
        </div>
        <div class="fields">
            <div class="field">
                <label>{{ trans("subscription_plans.type") }}</label>
                <select v-model="form.plan_limitation_type" class="ui dropdown">
                    <option value="">
                        {{ trans("subscription_plans.choose_plan") }}
                    </option>
                    <option value="Number">
                        {{ trans("subscription_plans.NUMBER") }}
                    </option>
                    <option value="Pay as you go">
                        {{ trans("subscription_plans.PAY_AS_YOU_GO") }}
                    </option>
                </select>
            </div>

            <div class="field" v-if="form.plan_limitation_type === 'Number'">
                <label> {{ trans("subscription_plans.max") }}</label>
                <input
                    v-model="form.max_templates_number"
                    type="number"
                    :placeholder="trans('subscription_plans.max')"
                />
            </div>
        </div>

        <div>
            <btn
                :text="trans('common.submit')"
                :bgColor="'#00b16e'"
                :textColor="'white'"
                :cls="'acc btn'"
                :font_Weight="'600'"
            />
        </div>
    </form>
</template>

<script>
import axios from "axios";
import btn from "../modules/tests/tests-components/btn.vue";
export default {
    components: { btn },
    props: ["onePlan", "screenName"],
    name: "subscription_plans",

    data() {
        return {
            form: {
                name: "",
                features: "",
                description: "",
                annual_price: "",
                monthly_price: "",
                individual_template_price: "",
                plan_limitation_type: "",
                max_templates_number: "",
            },
        };
    },
    methods: {
        trans(key) {
            return trans(key);
        },

        async addPlan() {
            try {
                const { data } = await axios.post("/api/plans", this.form);
                console.log(data);
                for (let key in this.form) {
                    this.form[key] = "";
                }

                window.location.reload();
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    console.error(error.response.data.errors);
                } else {
                    console.error(error);
                }
            }
        },

        getOnePlan() {
            this.form = { ...this.form, ...this.onePlan };
        },

        async updatePlan() {
            const { data } = await axios.put(
                `/api/plans/${this.onePlan.id}/update`,
                this.form
            );

            let updatedPlan = data.data;
            this.form = { ...this.form, ...updatedPlan };
            window.location.reload();
        },
    },

    mounted() {
        this.getOnePlan();
    },
};
</script>

<style scoped>
input:hover,
input:focus,
select:hover,
select:focus,
textarea:hover,
textarea:focus {
    border: 1px solid var(--project-primary-color) !important;
}
.form_container {
    background-color: white;
    box-shadow: 0 2px 4px rgba(0, 177, 110, 0.5);
    border-radius: 5px;
    padding: 30px;
    margin-top: 30px;
}
.btn {
    width: 100px;
    border: none;
}
.acc:hover {
    transition: all 0.2s ease;
    background-color: white !important;
    border: 1px solid var(--project-primary-color);
    color: black !important;
}
img {
    border: 1px solid var(--project-primary-color);
    position: relative;
    border-radius: 50%;
    width: 200px !important;
    height: 200px !important;
    object-fit: cover;
}
.btn_browse {
    position: absolute;
    bottom: 0 !important;
    left: 130px !important;
    z-index: 2;
    border-radius: 50% !important;
    width: 50px !important;
    height: 50px !important;
    object-fit: cover;
}

h1 {
    color: var(--project-primary-color);
    margin-bottom: 30px;
}

.error {
    color: #9f3a38;
    margin-top: 10px;
}
</style>
