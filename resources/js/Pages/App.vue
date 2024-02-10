<script setup>
    const props = defineProps(['name'])
</script>

<template>
    Hello, {{ props.name }}.
</template>
