<template>
    <button
        :style="{
            backgroundColor: bgColor,
            color: textColor,
            fontWeight: font_Weight,
            fontSize: font_size,
            width: btn_width,
            height: btn_height,
            border: btn_border,
        }"
        type="submit"
        :class="cls"
    >
        <span v-if="icon"><i :class="icon"></i></span>
        {{ text }}
    </button>
</template>

<script>
export default {
    name: "btn",

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
        "btn_border",
    ],
};
</script>

<style scoped>
button {
    border: none;
    height: 43px;
    cursor: pointer;
    border-radius: 5px;
}

.full_width {
    width: 100%;
}
</style>
