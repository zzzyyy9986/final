<template>
    <div>
        <div class="alert alert-success" v-if="message.status === 1" role="alert">
            {{ message.msg }}
        </div>
        <div class="alert alert-danger" v-if="message.status === -1" role="alert">
            {{ message.msg }}
        </div>
        <div class="alert alert-info" v-if="message.status === 2" role="alert">
            {{ message.msg }}
        </div>
    </div>
</template>

<script>
export default {
    name: "Message.vue",
    computed: {
        message: function () {
            return this.$store.getters.getMsg
        }
    },
    watch: {
        message: function () {
            if(this.message.status === 0) return
            setTimeout(() => {
                this.$store.commit("setDefaultMsg")
            }, 2000)
        }
    }
}
</script>

<style scoped>

</style>
