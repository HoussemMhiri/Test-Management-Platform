<template>
    <div class="card flex justify-content-center modal_container">
        <Button label="Show" @click="visible = true" class="acc btn"
            >{{ trans("tests.see_emails") }}
        </Button>

        <Dialog
            v-model:visible="visible"
            modal
            :header="computedHeader"
            :style="{ width: '50rem' }"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
            class="custom-dialog"
        >
            <input
                v-model="searchQuery"
                type="text"
                class="inputtext"
                :placeholder="trans('common.search')"
            />

            <ul>
                <p v-if="filteredEmails.length === 0" class="no-email-found">
                    <span><i class="pi pi-times-circle"></i></span>
                    {{ trans("tests.no_emails") }}.
                </p>

                <li
                    v-else
                    class="email"
                    v-for="email in filteredEmails"
                    :key="email"
                >
                    <span><i class="pi pi-envelope"></i></span> {{ email }}
                </li>
            </ul>
        </Dialog>
    </div>
</template>

<script>
import Dialog from "primevue/dialog";
import Button from "primevue/button";

export default {
    name: "modal-component",
    components: { Dialog, Button },
    props: ["emails", "title"],
    data() {
        return {
            visible: false,
            searchQuery: "",
        };
    },
    computed: {
        filteredEmails() {
            return this.emails.filter((email) =>
                email.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        },
        computedHeader() {
            return `${this.trans("tests.email_list")} ${this.title} invitation`;
        },
    },

    methods: {
        trans(key) {
            return trans(key);
        },
    },
};
</script>

<style scoped>
.btn {
    border: none;
    height: 43px;
    cursor: pointer;
    border-radius: 5px;
    font-weight: 600;
    min-width: 100px;
    margin-right: 10px !important;
    background-color: #00b16e;
    color: white;
}

.btn:focus {
    box-shadow: none !important;
    outline-color: none !important;
}

.acc:hover {
    transition: all 0.2s ease;
    background-color: white !important;
    border: 1px solid var(--project-primary-color) !important;
    color: black !important;
}

.inputtext {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ced4da !important;
    border-radius: 4px;
    margin-bottom: 1rem;
}
.inputtext:hover {
    border: 1px solid var(--project-primary-color) !important;
}

input:focus {
    outline-color: var(--project-primary-color) !important;
}

.email {
    margin-top: 15px;
}

.email::marker,
span {
    color: var(--project-primary-color);
}

.pi-times-circle {
    color: #ff4242;
    font-size: 16px;
}
</style>
<style>
.custom-dialog {
    border-radius: 8px;
    box-shadow: 0px 0px 20px rgba(0, 177, 110, 0.5) !important;
    font-size: 18px !important;
}

.custom-dialog .p-dialog-header .p-dialog-title {
    color: var(--project-primary-color) !important;
    font-size: 22px !important;
}
</style>
