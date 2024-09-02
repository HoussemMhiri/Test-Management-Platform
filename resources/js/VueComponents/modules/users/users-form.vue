<template>
    <form
        @submit.prevent="submitForm"
        class="ui equal width large form form_container"
    >
        <h1>{{ trans("user.title") }}</h1>
        <div class="field">
            <label>{{ trans("user.avatar") }}</label>
            <div class="ui action input">
                <input
                    ref="fileInput"
                    name="avatar"
                    type="file"
                    @change="handleFileUpload"
                    accept="image/*"
                    hidden
                />
                <div
                    style="background-color: #00b16e; color: white"
                    class="ui button acc btn_browse"
                    @click="selectFile"
                >
                    <i class="upload icon"></i>
                </div>
                <img
                    v-if="avatarPreview"
                    :src="avatarPreview"
                    alt="Avatar Preview"
                    class="ui small image"
                />
                <img
                    v-else
                    src="https://cdn-icons-png.freepik.com/512/147/147144.png"
                    alt="Avatar Preview"
                    class="ui small image"
                />
            </div>
        </div>
        <div class="fields names_field">
            <div class="field">
                <label>{{ trans("user.first_name") }}</label>
                <input
                    v-model="form.first_name"
                    type="text"
                    :placeholder="trans('user.first_name')"
                />
            </div>

            <div class="field">
                <label>{{ trans("user.last_name") }}</label>
                <input
                    v-model="form.last_name"
                    type="text"
                    :placeholder="trans('user.last_name')"
                />
            </div>

            <div class="field">
                <label>{{ trans("user.username") }}</label>
                <input
                    v-model="form.username"
                    type="text"
                    :placeholder="trans('user.username')"
                />
            </div>
        </div>

        <div class="fields">
            <div class="field">
                <label>{{ trans("user.country") }}</label>
                <input
                    v-model="form.country"
                    type="text"
                    :placeholder="trans('user.country')"
                />
            </div>

            <div class="field">
                <label>{{ trans("user.city") }}</label>
                <input
                    v-model="form.city"
                    type="text"
                    :placeholder="trans('user.city')"
                />
            </div>

            <div class="field">
                <label>{{ trans("user.postal_code") }}</label>
                <input
                    v-model="form.postal_code"
                    type="text"
                    :placeholder="trans('user.postal_code')"
                />
            </div>
        </div>
        <div class="fields">
            <div :class="[!emailErrMsg ? 'field' : 'field error']">
                <label>{{ trans("user.email") }}</label>
                <input
                    v-model="form.email"
                    type="email"
                    :placeholder="trans('user.email')"
                />
                <p v-if="emailErrMsg" class="error">
                    {{ emailErrMsg }}
                </p>
            </div>

            <div class="field">
                <label>{{ trans("user.password") }}</label>
                <input
                    v-model="form.password"
                    type="password"
                    :placeholder="trans('user.password')"
                />
            </div>
        </div>
        <div class="fields">
            <div class="field">
                <label>{{ trans("user.governorate") }}</label>
                <input
                    v-model="form.governorate"
                    type="text"
                    :placeholder="trans('user.governorate')"
                />
            </div>

            <div class="field">
                <label>{{ trans("user.address") }}</label>
                <input
                    v-model="form.address"
                    type="text"
                    :placeholder="trans('user.address')"
                />
            </div>
        </div>
        <div class="fields">
            <div class="field">
                <label>{{ trans("user.gender") }}</label>
                <select v-model="form.gender" class="ui dropdown">
                    <option value="">
                        {{ trans("gender-enum.gender_choice") }}
                    </option>
                    <option value="MALE">
                        {{ trans("gender-enum.MALE") }}
                    </option>
                    <option value="FEMALE">
                        {{ trans("gender-enum.FEMALE") }}
                    </option>
                </select>
            </div>

            <div class="field">
                <label>{{ trans("user.phone") }}</label>
                <input
                    v-model="form.phone"
                    type="text"
                    :placeholder="trans('user.phone')"
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
import btn from "../tests/tests-components/btn.vue";

export default {
    name: "users-form",

    components: { btn },

    data() {
        return {
            avatarPreview: null,
            form: {
                last_name: "",
                first_name: "",
                country: "",
                city: "",
                postal_code: "",
                governorate: "",
                address: "",
                gender: "",
                phone: "",
                username: "",
                avatar: null,
                email: "",
                password: "",
            },

            emailErrMsg: "",
        };
    },
    methods: {
        selectFile() {
            this.$refs.fileInput.click();
        },
        handleFileUpload(event) {
            let file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = (e) => {
                    this.avatarPreview = e.target.result;
                    this.form.avatar = file;
                };
            }
        },

        trans(key) {
            return trans(key);
        },

        validateEmail(email) {
            const emailPattern =
                /^[a-zA-Z0-9._%+-]+@(gmail|outlook|yahoo|protonmail|icloud|zoho|aol|yandex)\.(com|org|net)$/i;
            return emailPattern.test(email);
        },
        async getAuthUserData() {
            const { data } = await axios.get("/api/users");
            let authUserData = data?.user;

            authUserData.password = authUserData.decrypted_password;
            this.form = { ...this.form, ...authUserData };
            this.avatarPreview = this.form.avatar;
        },

        async updateAUthUserData() {
            try {
                let formData = new FormData();

                Object.entries(this.form).forEach(([key, value]) => {
                    formData.append(key, value);
                });

                formData.append("_method", "PUT");

                const { data } = await axios.post(
                    "/api/users/update",
                    formData
                );
            } catch (error) {
                console.log(error);
            }
        },

        async submitForm() {
            try {
                if (
                    this.form.email == "" ||
                    this.validateEmail(this.form.email)
                ) {
                    this.emailErrMsg = "";
                    this.updateAUthUserData();
                    for (let key in this.form) {
                        this.form[key] = "";
                    }
                    this.avatarPreview = "";

                    window.location.reload();
                } else {
                    this.emailErrMsg = "Please enter a valid email";
                }
            } catch (error) {
                console.log(error);
            }
        },
    },

    mounted() {
        this.getAuthUserData();
    },
};
</script>

<style scoped>
input:hover,
input:focus,
select:hover,
select:focus {
    border: 1px solid var(--project-primary-color) !important;
}
.form_container {
    background-color: white;
    box-shadow: 0 2px 4px rgba(0, 177, 110, 0.5);
    border-radius: 5px;
    padding: 30px;
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
