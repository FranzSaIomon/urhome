<template>
    <div class="col-md-4">
        <a :href="'/properties/view/' + card.id" class="card">
            <div v-if="card.listing_type.ListingType ==='rent'" class="badge rent">For Rent</div>
            <div v-else class="badge sale">For Sale</div>
            <img :data-src="card.property_document.Images['regular'][0]" :alt="card.Name + ' by ' + card.user.email" class="lazy text-center card-img-top" style="min-height: 282.4px" v-if="card.property_document && card.property_document.Images['regular'].length > 0">
            <img data-src="https://via.placeholder.com/282" :alt="card.Name + ' by ' + card.user.email" class="lazy text-center card-img-top" style="min-height: 282.4px" v-else>
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