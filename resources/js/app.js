/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

Vue.prototype.$extras = {};
Vue.component('slider', require('./components/Slider.vue').default);
Vue.component('properties', require('./components/Properties.vue').default);
Vue.component('multi-select', require('./components/MultiSelect.vue').default);

$(document).ready(() => {
    const slider = new Vue({
        el: "#filter",
    })

    const properties = new Vue({
        el: "#properties_cards",
        data: {
            cards: [{
                PropertyID: 1,
                Name: "2 Bedroom Condominium",
                City: "Pasig",
                PropertyType: {
                    PropertyType: "condominium"
                },
                Price: 1234567.00,
                NumberOfBedrooms: 2,
                NumberOfBathrooms: 3,
                FloorArea: 190,
                ListingType: {
                    ListingType: "rent"
                },
                PropertyDocument: {
                    ImageAttachment1: "https://via.placeholder.com/300",
                    ImageAttachment2: "https://via.placeholder.com/300",
                }
            }],
            count: 0,
        },
        methods: {
            add () {
                this.cards.push({
                    PropertyID: 1,
                    Name: "2 Bedroom Condominium",
                    City: "Pasig",
                    PropertyType: {
                        PropertyType: "condominium"
                    },
                    Price: 1234567.00,
                    NumberOfBedrooms: 2,
                    NumberOfBathrooms: 3,
                    FloorArea: 190,
                    ListingType: {
                        ListingType: "rent"
                    },
                    PropertyDocument: {
                        ImageAttachment1: "https://via.placeholder.com/300",
                        ImageAttachment2: "https://via.placeholder.com/300",
                    }
                })
            }
        }
    })
})