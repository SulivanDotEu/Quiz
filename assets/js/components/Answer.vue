<template>
    <div>
        <h2>{{ label }}</h2>
        <!--<button @click.prevent="changeLabel">Label</button>-->
    </div>
</template>

<script>
    export default {
        props: ['id', 'label'],
        methods: {},
    }
</script>

