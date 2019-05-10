<template>
    <div class="container">
        <div class="row properties">
            <propertycard v-for="card in cards" v-bind:card="card" v-bind:key="card.PropertyID"></propertycard>
        </div>
    </div>
</template>

<script>
    import PropertyCard from './PropertyCard'

    export default {
        data() {
            return {
                cards: this.$root.cards || [],
                loading: false
            }
        },
        mounted() {
            console.log(this.cards)
        },
        components: {
            'propertycard': PropertyCard
        }
    }
</script>