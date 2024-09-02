<template>
    <div>
        <Toast ref="toast" />

        <div class="ui small modal" ref="confirmationModal">
            <i class="close icon" @click="hideConfirmationModal"></i>
            <div class="header ui red inverted segment">
                {{ trans("tests.danger_zone") }}
            </div>
            <div class="content">
                <p>{{ trans("tests.are_you_want_delete") }}?</p>
            </div>
            <div class="actions">
                <div class="ui black deny button" @click="hideConfirmationModal">
                    <i class="remove icon"></i>
                    {{ trans("tests.cancel") }}
                </div>
                <div class="ui red approve button" @click="confirmDelete">
                    <i class="checkmark icon"></i>
                    {{ trans("tests.delete") }}
                </div>
            </div>
        </div>

        <div class="flex justify-content-center">
            <Button class="kebab_btn" type="button" icon="pi pi-ellipsis-v" @click="toggle" aria-haspopup="true"
                aria-controls="overlay_menu" />
            <Menu ref="menu" id="overlay_menu" :model="menuItems" :popup="true" />
        </div>

        <div v-if="showConfirmation" class="ui active dimmer">
            <div class="ui text loader">{{ trans("tests.loading") }}</div>
        </div>
    </div>
</template>


<script>
import axios from 'axios';
import Button from 'primevue/button';
import Menu from 'primevue/menu';
import Toast from 'primevue/toast';

export default {
    name: 'MenuDropdown',
    props: {
        test: {
            type: Object,
            required: true
        }
    },
    components: {
        Button,
        Menu,
        Toast
    },
    emits: ['editTest'],
    data() {
        return {
            menuItems: [
                { label: 'Edit', icon: 'pi pi-pencil', command: () => this.editTest(this.test.id) },
                { label: 'Delete', icon: 'pi pi-trash', command: () => this.showConfirmationModal() },
                { label: 'Print', icon: 'pi pi-print', command: () => this.printTest(this.test.id) },
                { label: 'Download', icon: 'pi pi-download', command: () => this.downloadTest(this.test.id) }
            ],
            showConfirmation: false
        };
    },
    methods: {
        trans(key) {
            return trans(key);
        },
        toggle(event) {
            this.$refs.menu.toggle(event);
        },
        editTest(testId) {
            window.location.href = `/tests/edit/${testId}`;
        },
        showConfirmationModal() {
            this.showConfirmation = true;
            this.$refs.confirmationModal.classList.add('visible', 'active');
            this.$refs.confirmationModal.style.display = 'block';
        },
        hideConfirmationModal() {
            this.showConfirmation = false;
            this.$refs.confirmationModal.classList.remove('visible', 'active');
            this.$refs.confirmationModal.style.display = 'none';
            this.showToast('warn', 'Cancelled', 'You have cancelled the operation');
        },
        confirmDelete() {
            const testId = this.test.id;
            axios
                .delete(`/api/tests/${testId}`, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                })
                .then((response) => {
                    console.log('Test deleted:', response);
                    this.showToast('success', 'Confirmed', 'Record deleted');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                })
                .catch((error) => {
                    console.error('Error deleting test:', error);
                    this.showToast('error', 'Error', 'Failed to delete test');
                })
                .finally(() => {
                    this.hideConfirmationModalNoToast();
                });
        },
        hideConfirmationModalNoToast() {
            this.showConfirmation = false;
            this.$refs.confirmationModal.classList.remove('visible', 'active');
            this.$refs.confirmationModal.style.display = 'none';
        },
        showToast(type, summary, detail) {
            this.$refs.toast.add({ severity: type, summary, detail, life: 3000 });
        },
        downloadTest(testId) {

           this.openAndDownload(`/download/test/${testId}`, 'template.pdf')
        },
        printTest(testId) {
            window.open(`/download/test/${testId}`, '_blank');
        },
        openAndDownload(url, filename) {
            // Create an anchor element
            const link = document.createElement('a');
            link.href = url;            // Set the URL to be opened
            link.target = '_blank';     // Set the target to open in a new tab
            link.download = filename;   // Set the download attribute with the desired file name

            // Append the anchor to the body
            document.body.appendChild(link);

            // Programmatically click the anchor
            link.click();

            // Remove the anchor from the document
            document.body.removeChild(link);
        }
    }
};
</script>


<style scoped>
.kebab_btn {
    background: none;
    color: black;
    border-color: #cdcdcd;
    width: 25px;
    height: 25px;
    transition: all 0.3s ease;
}

.kebab_btn:hover {
    background-color: #00b16e !important;
    color: white;
    border: none;
}

.ui.modal .content {
    text-align: center;
    padding: 20px;
}

.ui.modal .header.ui.red.inverted.segment {
    padding: 10px;
    border-radius: 0;
}

.ui.modal .actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
}

.ui.modal .actions .button {
    margin-left: 10px;
    min-width: 100px;
}

.ui.modal .actions .deny {
    background-color: #f4f4f4;
    color: #333;
}

.ui.modal .actions .approve {
    background-color: #db2828;
    color: white;
}

.ui.modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1001;
    width: 320px;
    background-color: white;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    transition: opacity 0.3s ease;
}

.ui.dimmer {
    display: block !important;
    background-color: rgba(0, 0, 0, 0.8) !important;
}

.ui.modal.visible.active {
    display: block !important;
    opacity: 1;
}

.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.ui.active.dimmer>.ui.loader:before {
    color: #db2828 !important;
}

.ui.active.dimmer .ui.text.loader {
    color: #db2828;
}
</style>
