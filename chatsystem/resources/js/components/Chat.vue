<script setup>
import { ref, onBeforeMount, nextTick } from 'vue';
import ChatItem from './ChatItem.vue'
import {data} from "autoprefixer";

const message = ref('')
const list_messages = ref([])

onBeforeMount(() => {
    loadMessage();
    Echo.channel('chat').listen("MessageSent", (data) => {
        const message = data.message;
        message.user = data.user;
        list_messages.value.push(message);

        scrollToBottom()
    })
});

async function loadMessage() {
    try {
        const response = await axios.get('/messages')
        list_messages.value = response.data

        scrollToBottom()
    } catch (error) {
        console.log(error)
    }
}

async function sendMessage() {
    try {
        const response = await axios.post('/messages', {
            message: message.value
        })
        list_messages.value.push(response.data.message)
        message.value = ''

        scrollToBottom()
    } catch (error) {
        console.log(error)
    }
}

function scrollToBottom() {
    nextTick(() => {
        const messages = document.querySelector('.messages')
        // scroll đến cuối cùng
        messages.scrollTo({
            top: messages.scrollHeight, // Scroll to the bottom
            behavior: 'smooth', // Smooth scrolling
        });
    })
}
</script>

<template>
    <div>
        <div class="chat">
            <div class="chat-title">
                <h1>Chat Box</h1>
            </div>
            <div class="messages">
                <ChatItem v-for="(message, index) in list_messages" :key="index" :message="message"></ChatItem>
            </div>
            <div class="message-box">
                <input type="text" v-model="message" @keyup.enter="sendMessage" class="message-input" placeholder="Type message..."/>
<!--                <button type="button" class="message-submit" @click="sendMessage">Send</button>-->
            </div>
        </div>
        <div class="bg"></div>
    </div>
</template>


<style lang="scss" scoped>
.messages {
    height: 80%;
    overflow-y: scroll;
    padding: 0 20px;
}

/*--------------------
Body
--------------------*/
.bg {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 1;
    transform: scale(1.2);
}

/*--------------------
Chat
--------------------*/
.chat {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 800px;
    height: 80vh;
    max-height: 700px;
    z-index: 2;
    overflow: hidden;
    box-shadow: 0 5px 30px rgba(0, 0, 0, .2);
    background-color: #333334;
    border-radius: 20px;
    display: flex;
    justify-content: space-between;
    flex-direction: column;
}

/*--------------------
Chat Title
--------------------*/
.chat-title {
    flex: 0 1 45px;
    position: relative;
    z-index: 2;
    background: rgba(0, 0, 0, 0.2);
    color: #fff;
    text-transform: uppercase;
    text-align: left;
    padding: 10px 10px 10px 50px;

    h1,
    h2 {
        font-weight: normal;
        font-size: 16px;
        margin: 0;
        padding: 0;
    }

    h2 {
        color: rgba(255, 255, 255, .5);
        font-size: 8px;
        letter-spacing: 1px;
    }

    .avatar {
        position: absolute;
        z-index: 1;
        top: 8px;
        left: 9px;
        border-radius: 30px;
        width: 30px;
        height: 30px;
        overflow: hidden;
        margin: 0;
        padding: 0;
        border: 2px solid rgba(255, 255, 255, 0.24);

        img {
            width: 100%;
            height: auto;
        }
    }
}

/*--------------------
Message Box
--------------------*/
.message-box {
    flex: 0 1 40px;
    width: 100%;
    background: rgba(0, 0, 0, 0.3);
    padding: 10px;
    position: relative;
    display: flex;
    gap: 8px;

    & .message-input {
        width: 100%;
        background: none;
        border: none;
        outline: none !important;
        resize: none;
        color: rgba(255, 255, 255, .7);
        font-size: 11px;
        height: 17px;
    }

    textarea:focus:-webkit-placeholder {
        color: transparent;
    }

    & .message-submit {
        color: #fff;
        border: none;
        background: #248A52;
        font-size: 10px;
        text-transform: uppercase;
        line-height: 1;
        padding: 6px 10px;
        border-radius: 10px;
        outline: none !important;
        transition: background .2s ease;

        &:hover {
            background: #1D7745;
        }
    }
}
</style>
