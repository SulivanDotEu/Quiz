<template>
       <div>
    <form>
        <input type="text" v-model="msg" />
    </form>

           <p>This is an example of a new components in VueJs: "{{ msg }}"</p>

       </div>
</template>

<script>
    export default {
        name: "example"
    }
</script>

<style scoped>
    p{color:red; background-color: greenyellow}
</style>