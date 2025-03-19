<script setup>
defineProps({
    message: Object
})
</script>

<template>
    <div
        class="message"
        :class="{ 'is-current-user': $root.currentUserLogin.id === message.user.id }"
    >
<!--        <div class="message-item user-name">-->
<!--            {{ message.user.name }} :-->
<!--        </div>-->
        <div class="message-item text-message">
            {{ message.message }}
        </div>
    </div>
</template>



<style lang="scss" scoped>
.message {
    display: flex;
    color: white;

    .message-item:not(:last-child) {
        margin-right: 5px;
    }
}

.message:not(:last-child) {
    padding-bottom: 20px;
}

.message-item {
    background-color: #252728;
    padding: 15px;
    border-radius: 25px;
}

.is-current-user {
    color: white;
    flex-direction: row-reverse;

    .message-item {
        background-image: linear-gradient(#aa00ff calc(100vh - 455px + 48px), #0080ff calc(100% - 56px), #0080ff)
    }
}


</style>
