<template>
    <div class="ui two column not_found_container">
        <div class="column">
            <img
                :src="
                    img
                        ? img
                        : '/images/modules/tests/tests-components/not-found.jpg'
                "
                alt="Not Found"
                class="not_found_img"
            />
        </div>
        <div class="column">
            <p>{{ title }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "not-found",

    props: ["title", "img"],
};
</script>

<style scoped>
.not_found_container {
    text-align: center;
    background-color: white;
    width: 100%;
    padding: 30px;
    box-shadow: 0 2px 4px rgba(0, 177, 110, 0.5);
    opacity: 0.6;
}
.not_found_container p {
    margin-top: 10px;
    font-size: 2em;
    letter-spacing: 0.3px;
}
.not_found_img {
    width: 500px;
    max-width: 100%;
    object-fit: cover;
}
</style>
