<template>
    <div class="fluid card card_container">
        <div class="content">
            <div class="kebab_dropdown_text">
                <p class="title">{{ test.title }}</p>
                <menu-dropdown :test="test" />
            </div>
            <div class="img_container">
                <img :src="test.thumbnail" class="test_img" alt="" />
            </div>
            <div class="btn_container">
                <button>{{ trans("common.open") }}</button>
            </div>
            <div class="label_container">
                <div class="circle"></div>
                <p>{{ test.description }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import MenuDropdown from "./menu-dropdown.vue";
export default {
    name: "test-card",

    components: { MenuDropdown },

    props: ["test"],

    methods: {
        trans(key) {
            return trans(key);
        },
    },
};
</script>

<style scoped>
.content {
    display: flex;
    flex-direction: column;
    height: 100%;
    justify-content: space-between;
}

.label_container {
    display: flex;
    align-items: center;
    margin-left: 10px;
    margin-top: 10px !important;
    font-size: 15px;
    font-weight: 600;
}
.circle {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #00b16e;
    margin-right: 10px;
}
.card_container {
    border: 1px solid #a7a7a7;
    width: 280px;
    max-width: 100%;
    padding: 10px !important;
    background-color: white;
    border-radius: 3px;
    cursor: pointer;
}

.card_container:hover {
    border: 1px solid #00b16e;
}
.card_container:hover .title {
    transition: all 0.3s ease-in-out;
    color: #00b16e;
}
.kebab_dropdown_text {
    display: flex;
    justify-content: space-between;
}

.kebab_dropdown_text p {
    font-weight: 600;
    font-size: 15px;
    letter-spacing: 0.5px;
}

.img_container {
    display: flex;
    align-items: center;
    justify-content: center;
}
.test_img {
    width: 190px;
    max-width: 100%;
    object-fit: cover;
    border-radius: 3px;
    margin-top: 10px;
}

.btn_container {
    width: 95%;
    margin-top: 25px;
    text-align: end;
}

.btn_container button {
    width: 55px;
    height: 25px;
    border-radius: 3px;
    cursor: pointer;
    border: none;
    background-color: #00b16e;
    color: white;
    letter-spacing: 0.3px;
    font-size: 13px;
}

.btn_container button:hover {
    transition: all 0.3s ease-in-out;
    background-color: #212832;
}
</style>
