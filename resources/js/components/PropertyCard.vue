<template>
    <div class="col-md-4">
        <a :href="'/properties/view/' + card.id" class="card">
            <div v-if="card.listing_type.ListingType ==='rent'" class="badge rent">For Rent</div>
            <div v-else class="badge sale">For Sale</div>
            <img :src="card.property_document.Image[0]" alt="" class="card-img-top" v-if="card.property_document && card.property_document.Image">
            <img src="https://via.placeholder.com/300" alt="" class="card-img-top" v-else>
            <div class="card-body">
                <h6 class="card-subtitle">{{ card.property_type.PropertyType }} | {{ card.City }}</h6>
                <h4 class="card-title">{{ card.Name }}</h4>
                <h5 class="card-title price">&#8369; {{ commaDisplayValue(card.Price) }}</h5>
                <div class="footer">
                    <span class="text-muted">
                        <i class="fas fa-bed"></i>
                        {{card.NumberOfBedrooms}} Bed/s
                    </span>

                    <span class="text-muted">
                        <i class="fas fa-bath"></i>
                        {{card.NumberOfBathrooms}} Baths/s
                    </span>

                    <span class="text-muted">
                        <i class="fas fa-home"></i>
                        {{card.FloorArea}} sqm.
                    </span>
                </div>
            </div>
        </a>
    </div>
</template>

<script>
    import CurrencyMixin from './mixins/CurrencyMixin';

    export default {
        props: ["card"],
        mixins: [CurrencyMixin],
        mounted() {
        }
    }
</script>