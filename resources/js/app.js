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

$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return null;
    }
    else{
       return results[1] || 0;
    }
}

$(document).ready(() => {
    const filter = new Vue({
        el: "#vue-filter",
        mixins: [FormMixin],
        created() {
            $.ajax({
                method: "GET",
                url: '/api/property/types',
            }).always((e) => {
                $.each(e, (i, o) => {
                    this.options.push({
                        name: o.PropertyType,
                        value: o.id
                    })
                    
                })
            })
        }, 
        data: {
            options: [],
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
        },
        methods: {
            search(e) {
                if ($("#vue-filter").is('[local]')) {
                    console.log(1)
                } else {
                    $("#vue-filter").submit()
                }
            }
        }
    });

    const login = new Vue({
        el: "#vue-login",
        data: {
            errors: {},
            values: {
                'email': 'hubert.gutmann@example.net',
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

    const properties = new Vue({
        el: "#properties_cards",
        data: {
            cards: [],
            pages: 0,
            page: 1,
        },
        methods: {
            changePage(page) {
                page = parseInt(page) || 1
                Vue.set(vue.$data, 'page', page)
                vue.search()
            }
        }
    })

    const vue = new Vue({
        el: "#vue-simple-search",
        mixins: [FormMixin],
        data: {
            toggles: [],
            options: [],
            values: {},
            errors: {},
            page: 1,
        },
        created() {
            $.ajax({
                method: "GET",
                url: '/api/property/types',
            }).always((e) => {
                this.options.push({
                    name: "All Types",
                    value: undefined
                })

                $.each(e, (i, o) => {
                    this.options.push({
                        name: o.PropertyType,
                        value: o.id
                    })
                })
            })

            $.ajax({
                method: "GET",
                url: '/api/listing/types',
            }).always((e) => {
                $.each(e, (i, o) => {
                    this.toggles.push({
                        name: "For " + o.ListingType,
                        value: o.id
                    })
                })
            })
        },
        methods:{
            search(e) {
                this.values.page = this.page

                if (this.page > 0 && (this.page <= properties.$data.pages || properties.$data.pages == 0)) {
                    $.ajax({
                        url: "/api/property/paginate",
                        method: "GET",
                        data: this.values,
                        success: (e) => {
                            Vue.set(properties.$data, 'cards', e.data)
                            properties.$data.pages = e.last_page;
    
                            if(e.current_page <= e.last_page)
                                properties.$data.page = this.page
                            else
                                properties.$data.page = e.last_page
                        },
                        error: (e) => {
                            console.dir(e)
                        }
                    })
                }
            }
        }
    })
    
    vue.search();
    $(".captcha-refresh").click(() => grecaptcha.reset())
})