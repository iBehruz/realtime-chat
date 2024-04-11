<script setup>
import SendIcon from 'vue-material-design-icons/Send.vue';
import {onMounted, onScopeDispose, onUpdated, ref, watch} from "vue";

const messages = ref([]);
const user = ref(window.User);
const text = ref('');
const box = ref();

const props = defineProps({
    user: Object,
    chat_id: String
})

const webSocketChannel = `chat.`+props.chat_id;


function scrollToEnd() {
    setTimeout(() => {
        box.value.scrollTop = box.value.scrollHeight;
    }, 0);
}

window.Echo.private(webSocketChannel)
    .listen('GotMessage', async (e) => {
        // e.message
        messages.value.push(e.message);
    });
onScopeDispose(()=>{
    Echo.leaveChannel(webSocketChannel);
})
function sendMessage(message) {
    if(message !== '' && message != null)
    axios.post('/message', {
        user_id: props.user.id,
        text: message,
        chat_id: props.chat_id
    })
        .then(function (response) {
        })
        .catch(function (error) {
        });
}

function getMessages() {
    axios.get('/messages', {
        params: {
            chat_id: props.chat_id
        }
    })
        .then(function (response) {
            messages.value = response.data;
        })
        .catch(function (error) {
        });
}



if(props.chat_id){
    getMessages()
}

watch(messages, async (newMessages, oldMessages) => {
    scrollToEnd();
}, { deep: true })

</script>

<template>

        <div class="w-100" style="height: 30px; background: grey; padding: 3px;">
           <span v-if="props.user?.id != null">  {{props.user?.name}} | id:{{props.chat_id}} </span>
            <span v-if="props.user?.id == null"> Выберите чат из списка </span>
        </div>
        <div class="px-4 h-100 d-flex flex-column justify-content-between">
            <div class="h-100 d-flex justify-content-center align-items-center box-hide-scroll" style="overflow: scroll">
                                        <span v-if="messages.length <= 0" style="color: grey;">
                                            Нет истории сообщение
                                        </span>
                <div v-if="messages.length > 0" ref="box" class="h-100 w-100 d-flex flex-column pt-2 box-hide-scroll" style="overflow-y: scroll">
                    <div v-for="message in messages" class="d-flex w-100" :class="user.id === message.user_id ? ['justify-content-end'] : ['justify-content-start']">
                        <div class="px-2 py-1 mt-2" :class="user.id === message.user_id ? ['user-message-owner'] : ['user-message']">
                            {{message.text}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center" style="height: 100px; margin-bottom: 24px;">
                <div class="d-flex w-100 align-items-center">
                    <input v-on:keyup.enter="()=>{sendMessage(text); text = '';}"  v-model="text" class="w-100 px-3" style="height: 35px;border-radius: 12px;border: thin solid #c6c8ca;">
                    <SendIcon ref="sendBtn" @click="sendMessage(text); text = ''" style="cursor: pointer" class="px-2" size="45"></SendIcon>
                </div>
            </div>
        </div>

</template>

<style scoped>

.box-hide-scroll::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.box-hide-scroll {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}

.user-message{
    width: max-content; background: grey; color: white; border-radius: 10px;
}

.user-message-owner{
    width: max-content; background: dodgerblue; color: white; border-radius: 10px;
}
</style>
