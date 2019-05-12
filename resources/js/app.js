/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import FormMixin from './components/mixins/FormMixin';
require('./bootstrap');
window.Vue = require('vue');

Vue.prototype.$extras = {};
Vue.component('slider', require('./components/Slider.vue').default);
Vue.component('properties', require('./components/Properties.vue').default);
Vue.component('multi-select', require('./components/MultiSelect.vue').default);
Vue.component('input-group', require('./components/InputGroup.vue').default);
Vue.component('toggle-button', require('./components/ToggleButton.vue').default);

$(document).ready(() => {
    const filter = new Vue({
        el: "#vue-filter",
        mixins: [FormMixin],
        data: {
            options: [
                {name: 'Townhouse', value: 1},
                {name: 'Condominium', value: 2},
                {name: 'House', value: 3},
                {name: 'Lot', value: 4},
                {name: 'Service Apartment', value: 5},
                {name: 'Condotel', value: 6},
                {name: 'Retail', value: 7},
            ],
            toggles: [
                {
                    name: 'For Rent',
                    value: 1
                },{
                    name: 'For Sale',
                    value: 2
                }
            ],
            values: {},
            errors: {},
        }
    });

    const login = new Vue({
        el: "#vue-login",
        data: {
            errors: {},
            values: {
                'email': 'emerald.gerhold@example.com',
                'password': 'password'
            }
        },
        mixins: [FormMixin],
        methods: {
            login() {
                // Remember: https://vuejs.org/v2/guide/list.html#Caveats
                let securities = this.getSecurities()
                Vue.set(this.values, Object.keys(securities)[0], Object.values(securities)[0])
                Vue.set(this.values, Object.keys(securities)[1], Object.values(securities)[1])

                $("#vue-login button[type=submit] .spinner-border").removeAttr('hidden')
                $.ajax({
                    url: '/login',
                    method: "POST",
                    data: this.values,
                    success: (e) => {
                        $("#vue-login .alert-success").removeAttr('hidden')
                        location.reload()
                    },
                    error: (e) => {
                        $.each(e.responseJSON.errors, (key, val) => Vue.set(this.errors, key, val))
                        if (e.responseJSON.errors["g-recaptcha-response"]) {
                            let captcha_elem = $(this.$el).find('.g-recaptcha');

                            captcha_elem.find('> div')
                                .css("border", '1px solid #e3342f')
                            
                            captcha_elem.find('+.invalid-feedback')
                                .css('display', 'block')
                                .text(e.responseJSON.errors['g-recaptcha-response'])
                        }
                    }
                }).always((e) => {
                    $("#vue-login button[type=submit] .spinner-border").attr('hidden', 'hidden')
                    grecaptcha.reset()
                })
            }
        }
    })

    const register = new Vue({
        el: "#vue-register",
        mixins: [FormMixin],
        data: {
            errors: {},
            values: {
                FirstName: "Miguel",
                LastName: "Quiambao",
                BirthDate: "1998-03-31",
                ContactNo: "09178510533",
                LotNo: 123,
                Street: "N. Domingo",
                City: "San Juan",
                Country: "PH",
                email: "miguelalfonsoquiambao@gmail.com",
                password: "password",
                password_confirmation: "password",
                UserType: [1],
            },
            toggles: [{
                name: 'Client',
                value: 1
            },{
                name: 'Broker',
                value: 2
            }]
        },
        methods: {
            register() {
                let securities = this.getSecurities()
                Vue.set(this.values, Object.keys(securities)[0], Object.values(securities)[0])
                Vue.set(this.values, Object.keys(securities)[1], Object.values(securities)[1])
                this.values.UserType = this.values.UserType[0]
                
                $("#vue-register button[type=submit] .spinner-border").removeAttr('hidden')
                $.ajax({
                    url: '/register',
                    method: 'POST',
                    data: this.values,
                    success: (e) => {
                        $("#vue-register .alert-success").removeAttr('hidden')
                    },
                    error: (e) => {
                        $.each(e.responseJSON.errors, (key, val) => Vue.set(this.errors, key, val))
                    }
                }).always((e) => {
                    $("#vue-register button[type=submit] .spinner-border").attr('hidden', 'hidden')
                    this.values.UserType = [this.values.UserType]
                })
            }
        }
    })
})