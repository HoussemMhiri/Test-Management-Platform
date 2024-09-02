<template>
    <div
        :class="[
            viewName === 'bars'
                ? 'all_container'
                : 'fluid card fluid_container',
        ]"
    >
        <div class="item">
            <div class="ui grid stackable decription_container">
                <div :class="[viewName === 'bars' ? 'img_container' : 'image']">
                    <img
                        :src="
                            item?.test_session?.test?.thumbnail
                                ? item?.test_session?.test?.thumbnail
                                : 'https://www.brainchecker.in/assets/front/images/psychometrictest.jpg'
                        "
                        class="test_img"
                    />
                </div>
                <div :class="[viewName === 'bars' ? '' : 'content']">
                    <h2 class="header">
                        {{ item?.test_session?.test?.title }}
                    </h2>
                    <div :class="[viewName === 'bars' ? '' : 'meta']">
                        <div class="desc">
                            <p>{{ trans("tests.duration") }}:</p>
                            <span>{{
                                item?.test_session?.test?.duration
                            }}</span>
                        </div>
                        <div class="desc">
                            <p>{{ trans("tests.started_at") }}:</p>
                            <span>{{ item?.start_at }}</span>
                        </div>
                        <div class="desc">
                            <p>{{ trans("tests.ended_at") }}:</p>
                            <span>{{ item?.end_at }}</span>
                        </div>
                        <div class="desc">
                            <p>{{ trans("tests.score") }}:</p>
                            <p>{{ item?.test_session?.test?.passing_score }}</p>
                        </div>
                        <div class="desc">
                            <p>{{ trans("tests.passed_by") }}:</p>
                            <span>{{
                                item?.test_session?.test?.creator?.username
                            }}</span>
                        </div>
                    </div>
                </div>

                <label-component
                    :cls="'ui top right attached label'"
                    :text="item.result"
                    :font_size="'15px'"
                    :bgColor="[
                        item.result === 'Failed' || item.result === 'FAILED'
                            ? '#ff4242'
                            : 'var(--project-primary-color)',
                    ]"
                    :textColor="'white'"
                    :btn_width="'118px'"
                />
            </div>
        </div>
    </div>
</template>

<script>
import labelComponent from "../tests-components/label-component.vue";
export default {
    components: { labelComponent },
    name: "attempts-segment",
    props: ["item", "viewName"],

    methods: {
        trans(key) {
            return trans(key);
        },
    },
};
</script>
<style scoped>
.img_container {
    display: flex;
    align-items: center;
}
.image {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
}

.image img {
    object-fit: cover;
    margin: 15px 0;
}
.content {
    text-align: center;
    width: 100%;
}

.fluid_container {
    margin-bottom: 30px !important;
    padding: 10px !important;
    border: 1px solid transparent !important;
    cursor: pointer;
}

.fluid_container:hover {
    border: 1px solid var(--project-primary-color) !important;
}
.all_container {
    margin: 20px 0;
    background-color: white !important;
    width: 100%;
    max-width: 100%;
    position: relative;
    border: 1px solid transparent;
    cursor: pointer;
    padding-bottom: 30px;
}
.all_container:hover {
    border: 1px solid var(--project-primary-color);
}

.decription_container {
    display: flex;
    padding: 30px 10px !important;
}

.desc {
    display: flex;
}

.desc p {
    margin: 4px 0;
    margin-right: 5px;
    font-weight: 600 !important;
    font-size: 16px;
    color: black !important;
}

.test_img {
    width: 200px;
    object-fit: cover;
}

span {
    margin: 4px 0;
    font-weight: 500;
    font-size: 16px;
    color: black !important;
}
</style>
