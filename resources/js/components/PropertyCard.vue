<template>
    <div>
        {{ card.id }}
    </div>
</template>

<script>
    export default {
        props: ["card"],
        mounted() {
            console.log('MOunted');
        }
    }
</script>