<template>
    <div
        :class="cls"
        :style="{
            backgroundColor: bgColor,
            color: textColor,
            fontWeight: font_Weight,
            fontSize: font_size,
            width: btn_width,
            height: btn_height,
        }"
    >
        <span v-if="icon"><i :class="icon"></i></span>
        {{ text }}
    </div>
</template>

<script>
export default {
    name: "label-component",

    props: [
        "bgColor",
        "textColor",
        "text",
        "font_Weight",
        "font_size",
        "icon",
        "btn_width",
        "cls",
        "btn_height",
    ],
};
</script>

<style scoped>
div {
    height: 33px;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}
</style>
