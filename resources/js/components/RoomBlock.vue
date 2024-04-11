<script setup>
import MailboxIcon from 'vue-material-design-icons/Mailbox.vue'
import {ref} from "vue";
import UserService from '../services/UserService.js';
import AccountCircleOutlineIcon from "vue-material-design-icons/AccountCircleOutline.vue";
const user = ref(window.User);

const props = defineProps({
    user: Object,
    selected: {
        type: Boolean,
        default: false
    }
})
</script>

<template>
    <div :class="props.selected ? ['room-block-selected'] : []" class="row w-100 room-block align-items-center justify-content-between ">
        <div class="col-2 d-flex align-items-center justify-content-center"><AccountCircleOutlineIcon size="30"></AccountCircleOutlineIcon></div>
        <div class="col-10 d-flex start flex-column">
            <div class="d-flex">{{props.user.name}}</div>
            <div class="d-flex">{{props.user.email}}</div>
        </div>
    </div>
</template>

<style scoped>
.room-block:hover{
    background: lightgrey;
}

.room-block-selected{
    background: lightgrey!important;
}

.room-block{
    border: none;
    cursor: pointer;
    height: 80px;
    background: whitesmoke;
    border-radius: 20px;
    margin-left: 2px;
}
</style>
