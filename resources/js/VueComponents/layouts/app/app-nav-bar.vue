<template>
    <nav class="navbar">
        <div class="container">
            <div class="navbar__left">
                <a href="#" class="header">{{
                    trans("tests.list_of_tests")
                }}</a>
            </div>
            <div class="navbar__right">
                <div class="icon">
                    <a href="#" class="navbar__icon"
                        ><i class="fas fa-search"></i
                    ></a>
                    <a
                        class="navbar__icon"
                        @click="toggle"
                        style="position: relative"
                    >
                        <Badge
                            v-if="badgeValue > 0"
                            class="custom-badge"
                            :value="badgeValue"
                            severity="danger"
                            style="
                                position: absolute;
                                top: -5px;
                                right: -5px;
                                transform: translate(50%, -50%);
                            "
                        >
                        </Badge>
                        <i class="fas fa-bell"></i>
                    </a>

                    <a href="/users/edit" class="navbar__icon">
                        <i class="fas fa-user"></i>
                    </a>
                </div>
                <div class="premium-btn">
                    <btn
                        :bgColor="'#00b16e'"
                        :textColor="'white'"
                        :text="trans('tests.try_premium')"
                        :icon="'star outline icon'"
                        :font_Weight="600"
                        :cls="'prem'"
                    />
                </div>
            </div>
        </div>
        <div class="">
            <OverlayPanel ref="op" class="custom-overlay-panel">
                <div class="notification-container">
                    <h3 class="notification-header">
                        {{ trans("tests.notification") }}
                    </h3>
                    <ul v-if="messages.length > 0" class="notification-list">
                        <li
                            v-for="message in messages"
                            :key="message.id"
                            class="notification-item"
                            :class="[message.read_at ? 'notif_read' : '']"
                        >
                            <img
                                :src="
                                    message?.data?.avatar
                                        ? message?.data?.avatar
                                        : 'https://cdn-icons-png.freepik.com/512/147/147144.png'
                                "
                                class="notification-avatar"
                            />

                            <div class="notification-content">
                                <span class="notification-name">{{
                                    message?.data?.username
                                }}</span>
                                <span class="notification-email">{{
                                    message?.data?.email
                                }}</span>

                                <span class="notification-email">
                                    <i
                                        class="clipboard outline icon"
                                        style="margin-left: -2px"
                                    ></i>
                                    {{ message?.data?.test }}
                                </span>
                                <span
                                    class="session_message"
                                    v-if="message.data.message"
                                >
                                    {{ message.data.message }}
                                </span>
                                <span
                                    v-if="message?.data?.status"
                                    class="notification-status"
                                    :class="[
                                        message?.data?.status == 'Accepted'
                                            ? 'status_accepted'
                                            : 'status_declined',
                                    ]"
                                    style="margin: 1px 0"
                                    ><i
                                        :class="[
                                            message?.data?.status == 'Accepted'
                                                ? 'pi pi-check-circle'
                                                : 'pi pi-times-circle',
                                        ]"
                                        style="font-size: 12px"
                                    ></i>
                                    {{ message?.data?.status }}</span
                                >
                            </div>
                            <div
                                :class="[
                                    message.read_at ? 'isRead' : 'read_notif',
                                ]"
                                @click="
                                    markAsRead(
                                        message.data.id
                                            ? message.data.id
                                            : message.id
                                    )
                                "
                            >
                                <i
                                    :class="[
                                        'pi',
                                        message.read_at
                                            ? 'pi-eye-slash'
                                            : 'pi-eye',
                                    ]"
                                    style="font-size: 18px"
                                ></i>
                            </div>
                        </li>
                    </ul>
                    <div v-else class="no-notifications">
                        <i
                            class="bell slash icon"
                            style="font-size: 25px; margin-bottom: 0.5rem"
                        ></i>
                        <p>{{ trans("tests.no_notification") }}</p>
                    </div>
                </div>
            </OverlayPanel>
        </div>
    </nav>
</template>

<script>
import Pusher from "pusher-js";
import btn from "../../modules/tests/tests-components/btn.vue";
import OverlayPanel from "primevue/overlaypanel";
import axios from "axios";
import Badge from "primevue/badge";

export default {
    components: { btn, OverlayPanel, Badge },
    name: "app-nav-bar",

    data() {
        return {
            messages: [],
            badge: "",
        };
    },

    methods: {
        trans(key) {
            return trans(key);
        },
        toggle(event) {
            this.$refs.op.toggle(event);
        },

        async fetchNotifications() {
            const { data } = await axios.get("/api/notifications");
            console.log(data.data);

            this.messages = data?.data;
        },

        async markAsRead(id) {
            try {
                const { data } = await axios.put(
                    `/api/notifications/${id}/read`
                );
                await this.fetchNotifications();
            } catch (error) {
                console.error(error);
            }
        },
    },

    computed: {
        badgeValue() {
            return (this.badge = this.messages.filter(
                (message) => message.read_at == null
            )).length;
        },
    },

    mounted() {
        this.fetchNotifications();

        const pusher = new Pusher("d04ad281d9092d4f914a", {
            cluster: "eu",
        });

        let channel = pusher.subscribe("my-channel");

        channel.bind("my-event", (data) => {
            console.log("New test update notification:", data);
            this.messages.push(data);
            this.fetchNotifications();
        });
        pusher.connection.bind("connected", () => {
            console.log("Connected to Pusher");
        });

        pusher.connection.bind("disconnected", () => {
            console.log("Disconnected from Pusher");
        });

        pusher.connection.bind("error", (err) => {
            console.error("Error with Pusher connection:", err);
        });
    },
};
</script>

<style scoped>
.session_message {
    display: inline-block;
    width: 88%;
    margin-top: 2px;
}

.isRead {
    color: red;
}

.notif_read {
    background-color: #f9f9f9;
    padding: 10px;
    margin: 5px 0;
    border-left: 4px solid #cfcfcf;
}
.notification-container {
    max-height: 400px;
    overflow-y: auto;
    padding: 10px;
}

.notification-container::-webkit-scrollbar {
    width: 8px;
}

.notification-container::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.notification-container::-webkit-scrollbar-thumb {
    background: #888;
}

.notification-container::-webkit-scrollbar-thumb:hover {
    background: #555;
}
.prem:hover {
    background-color: white !important;
    color: var(--project-primary-color) !important;
    border: 1px solid var(--project-primary-color);
    transition: all 0.2s ease-in;
}
.navbar {
    background-color: #fff;
    color: #080808;
    border-bottom: 1px solid #eee;
    margin-bottom: 14px;
}

.header {
    color: #050505;
    text-decoration: none;
    font-weight: bold;
    font-size: 20px;
}

.navbar__left {
    flex: 1;
}

.navbar__right {
    display: flex;
    align-content: space-between;
    align-items: center;
}

.navbar__icon {
    color: var(--project-primary-color);
    text-decoration: none;
    margin-right: 15px !important;
    cursor: pointer;
}

.navbar__icon i {
    font-size: 18px;
}

.container {
    display: flex;
    align-items: center;
}

.status_accepted {
    color: var(--project-primary-color);
}
.status_declined {
    color: #ff4242;
}

.no-notifications {
    margin-top: 20px;
    padding: 1rem;
    text-align: center;
    background-color: #f2f2f2;
    border-radius: 8px;
    color: black;
}

.no-notifications p {
    font-size: 16px;
}

.custom-badge {
    height: 20px;
}
</style>

<style>
.custom-overlay-panel {
    padding: 5px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.notification-container {
    width: 300px;
}

.notification-header {
    margin: 0;
    padding: 0.3rem 0;
    font-size: 1.25rem;
    border-bottom: 1px solid #eee;
}

.notification-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.notification-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #eee;
    cursor: pointer;
}
.notification-item:hover .notification-name {
    color: var(--project-primary-color);
}
.notification-item:hover .notification-avatar {
    outline: 2px solid var(--project-primary-color);
}
.read_notif:hover {
    color: var(--project-primary-color);
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-avatar {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 50%;
    margin-right: 1rem;
}

.notification-content {
    flex: 1;
}

.notification-name {
    display: block;
    font-weight: bold;
}

.notification-email {
    display: block;
    font-size: 14px;
    color: #666;
}

.notification-status {
    display: block;
    font-size: 12px;
    color: #999;
    font-weight: 600;
}
</style>
