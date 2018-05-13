<template>
    <div>
        <p>{{ message }}</p>
        <button @click.prevent="changeMessage">Click</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: "Hello world"
        }
    },
    methods: {
        changeMessage() {
            this.message = "This is a test"
        }
    },
}
</script>

