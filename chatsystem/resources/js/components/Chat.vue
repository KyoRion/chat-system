<template>
    <div>
        <div v-for="message in messages" :key="message.id">
            <strong>{{ message.user.name }}:</strong> {{ message.message }}
        </div>
        <input v-model="newMessage" @keyup.enter="sendMessage" placeholder="Type your message...">
    </div>
</template>

<script>
export default {
    data() {
        return {
            messages: [],
            newMessage: ''
        };
    },
    mounted() {
        this.fetchMessages();
        Echo.channel('chat').listen('MessageSent', (message) => {
            console.log('Message received:', message.message);
            this.messages.push(message);
        });
    },
    methods: {
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data;
            });
        },
        sendMessage() {
            axios.post('/messages', {
                message: this.newMessage
            }).then(response => {
                this.newMessage = '';
            });
        }
    }
};
</script>
