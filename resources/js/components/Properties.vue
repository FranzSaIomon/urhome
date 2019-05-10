<template>
    <div class="properties">
        <propertycard v-for="card in cards" v-bind:card="card" v-bind:key="card.id"></propertycard>
    </div>
</template>

<script>
    import PropertyCard from './PropertyCard'

    export default {
        data() {
            return {
                loading: false
            }
        },
        props: {
            cards: Array
        },
        mounted() {
            
        },
        components: {
            'propertycard': PropertyCard
        }
    }
</script>