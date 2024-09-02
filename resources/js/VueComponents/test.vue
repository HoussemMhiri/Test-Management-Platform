<template>
    hello component
    <button @click="alertSwal" class="ui primary button">
        hello
    </button>

    <button @click="deleteBtn" class="ui primary button">
        delete
    </button>

    <div>
        <textarea name="editor" id="editor"></textarea>
    </div>

    <Dropdown v-model="selectedCity" :options="cities" optionLabel="name" placeholder="Select a City" />

</template>

<script>

import Dropdown from 'primevue/dropdown';

export default {
    name: "test",
    components:{Dropdown},
    data() {
        return {
            /* CKEditor*/
            selectedCity: null,
            cities: [
                {name: 'New York', code: 'NY'},
                {name: 'Rome', code: 'RM'},
                {name: 'London', code: 'LDN'},
                {name: 'Istanbul', code: 'IST'},
                {name: 'Paris', code: 'PRS'}
            ]
        }
    },
    methods:{
        alertSwal()
        {
            showToast('sucessfull', 'added successfully', 'success')
        },
        deleteBtn()
        {
            DangerConfirmation().then((result) => {
                if(result.isConfirmed)
                {
                    alert("confirmed")
                }
                else{
                    alert("aborted")
                }
            })
        }
    },
    mounted()
    {
        console.log(trans('common.test'))
        console.log(trans_choice('common.item', 2))

        // CKEditor.replace('editor');
    }
}
</script>

<style scoped>

</style>
