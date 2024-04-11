<script setup>
import ChatBox from "./ChatBox.vue";
import BlurIcon from 'vue-material-design-icons/Blur.vue';
import {onMounted, onUpdated, ref} from "vue";
import RoomBlock from "./RoomBlock.vue";
import UserService from "../services/UserService.js";

const messages = ref([]);
const user = ref(window.User);
const box = ref();
const text = ref();

const users = ref([]);

const UsersData = UserService.getChatUsers();
UsersData.then((result)=>{
    users.value = result.data;
});

const selectedChat = ref({

});

function inputChange(el){
    let value = el.target.value;
    if(value !== '' && value != null){
        let UsersData = UserService.getUsers();
        UsersData.then((result)=>{
            users.value = result.data;
        });
    }else{
        let UsersData = UserService.getChatUsers();
        UsersData.then((result)=>{
            users.value = result.data;
        });
    }
}

</script>

<template>
    <div class="d-flex w-100">
        <div class="d-flex w-100">
            <div class="d-flex w-100">
                <div class="card w-100">
                    <div class="card-header text-h3 px-4"><BlurIcon size="32"></BlurIcon> Chaty</div>
                    <div class="card-body py-0 px-1" style="height: calc(100vh - 70px); overflow: hidden;">
                        <div class="row no-gutters h-100">
                            <div class="col-4 justify-content-center py-2 px-3">
                                <input @input="inputChange"  placeholder="Поиск..." v-model="text" class="w-100 px-3 mt-2" style="height: 35px;border-radius: 12px;border: thin solid #c6c8ca;">
                                <RoomBlock :selected="selectedChat.user?.id === user?.id" @click="selectedChat = {user: user, chat_id: user.chat_id}" v-for="user in users" :user="user" class="mt-2"></RoomBlock>
                            </div>
                            <div  class="col-8 justify-content-center h-100 px-0" style="border-left: thin solid #c6c8ca;">
                                <ChatBox :key="selectedChat.chat_id" :chat_id="selectedChat.chat_id" :user="selectedChat.user"></ChatBox>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
html, body {margin: 0; height: 100%; overflow: hidden}

.text-h3{
    font-size: 32px;
}

</style>


