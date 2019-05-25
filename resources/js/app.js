import FormMixin from './components/mixins/FormMixin'
import PropertyCardsMixin from './components/mixins/PropertyCardsMixin'
require('./bootstrap')

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
       return results[1] || null;
    }
}

$(document).ready(() => {
    if ($("#vue-filter").length) {
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
    }


    if ($("#vue-login").length) {
        const login = new Vue({
            el: "#vue-login",
            data: {
                errors: {},
                values: {
                    'email': 'hubert.gutmann@example.net',
                    'password': 'password'
                },
                loginForm: true,
                formChanged: false,
                success: undefined,
            },
            mixins: [FormMixin],
            updated() {
                if (this.formChanged && this.loginForm) {
                    this.formChanged = false

                    grecaptcha.render($('.g-recaptcha')[0], {
                        sitekey: this.sitekey
                    })
                }
            },
            methods: {
                login() {
                    // Remember: https://vuejs.org/v2/guide/list.html#Caveats
                    if (this.loginForm) {
                        let securities = this.getSecurities()
                        Vue.set(this.values, Object.keys(securities)[0], Object.values(securities)[0])
                        Vue.set(this.values, Object.keys(securities)[1], Object.values(securities)[1])

                        this.errors = {}
                        this.success = undefined
                        $("#vue-login button[type=submit] .spinner-border").removeAttr('hidden')
                        $.ajax({
                            url: '/login',
                            method: "POST",
                            data: this.values,
                            success: (e) => {
                                this.success = "<b>Success!</b> You've successfully logged in, please wait to be redirected..."
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
                },
                reset() {
                    let securities = this.getSecurities()
                    Vue.set(this.values, Object.keys(securities)[0], Object.values(securities)[0])

                    $.ajax({
                        url: '/password/email',
                        method: "POST",
                        data: this.values,
                        success: (e) => {
                            this.success = e.status
                        },
                        error: (e) => {
                            $.each(e.responseJSON.errors, (key, val) => Vue.set(this.errors, key, val))
                        }
                    })
                },
                changeForm() {
                    this.loginForm = !this.loginForm
                    this.formChanged = true
                    this.success = undefined
                    this.errors = {} 
                }
            }
        })
    }

    if ($("#vue-register").length) {
        const register = new Vue({
            el: "#vue-register",
            mixins: [FormMixin],
            data: {
                errors: {},
                success: undefined,
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
    
                    this.errors = {}
                    this.success = undefined
                    
                    $("#vue-register button[type=submit] .spinner-border").removeAttr('hidden')
                    $("#vue-register button[type=submit]").attr("disabled", "disabled")
                    $.ajax({
                        url: '/register',
                        method: 'POST',
                        data: this.values,
                        success: (e) => {
                            this.success = "<b>Success!</b> You've successfully registered, please wait to be redirected..."
                            location.reload()
                        },
                        error: (e) => {
                            console.log(e)
                            $.each(e.responseJSON.errors, (key, val) => Vue.set(this.errors, key, val))
                        }
                    }).always((e) => {
                        $("#vue-register button[type=submit] .spinner-border").attr('hidden', 'hidden')
                        $("#vue-register button[type=submit]").removeAttr("disabled")
                        this.values.UserType = [this.values.UserType]
                    })
                }
            }
        })
    }

    if ($("#vue-simple-search").length && $("#properties_cards").length) {
        const search = new Vue({
            el: "#vue-simple-search",
            mixins: [FormMixin],
            data: {
                toggles: [],
                options: [],
                values: {},
                errors: {},
                page: 1,
                shown: false,
                ignoreAdvanced: $.urlParam('ignoreAdvanced') ? true : false,
                lastPage: 1
            },
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
            mounted() {
                let range = [
                    "NumberOfBedrooms", "NumberOfBathrooms", "Price",
                    "LotArea", "FloorArea"
                ]

                let string = ["query", "location"]

                $.each(range, (i, v) => {
                    if ($.urlParam(v)) {
                        let values = decodeURIComponent($.urlParam(v)).split(',')
                        this.values[v][0] = parseInt(values[0], 10)
                        this.values[v][1] = parseInt(values[1], 10)

                        this.$refs[v].start = this.values[v][0]
                        this.$refs[v].end = this.values[v][1]

                        if (this.$refs[v].maximums)
                            this.$refs[v].max = this.$refs[v].maximums.find((el) => {
                                return this.values[v][1] <= el
                            })
                        
                        this.$refs[v].updateLimits()
                        this.$refs[v].updateStart()
                    }
                })

                $.each(string, (i, v) => {
                    if ($.urlParam(v))
                        Vue.set(this.values, v, decodeURIComponent($.urlParam(v)))
                })

                if ($.urlParam('type')) 
                    Vue.set(this.values, 'type', decodeURIComponent($.urlParam('type')).split(","))
                
                if ($.urlParam('purpose'))
                    Vue.set(this.values, 'purpose', decodeURIComponent($.urlParam('purpose')))
            },
            methods:{
                search(clear) {
                    this.values.page = (clear) ? 1 : this.page
                    Vue.set(properties.$data, 'loading', true)

                    let blacklist = [
                        "NumberOfBedrooms", "NumberOfBathrooms", "Price", 
                        "LotArea", "FloorArea"
                    ]

                    let nonAdvanced = {}

                    for (let key in this.values)
                        if (blacklist.indexOf(key) == -1)
                            nonAdvanced[key] = this.values[key]
                    
                    $.ajax({
                        url: "/api/property/paginate",
                        method: "GET",
                        data: !this.ignoreAdvanced ? this.values : nonAdvanced,
                        success: (e) => {
                            if (clear) {
                                this.page = 0
                                this.lastPage = 0
                                Vue.set(properties.$data, 'cards', [])
                            }

                            Vue.set(properties.$data, 'resultCount', e.total)
                            
                            $.each(e.data, (i, o) => properties.cards.push(o))
                            this.lastPage = e.last_page
                            this.page++
                        },
                        error: (e) => {
                            console.dir(e)
                        }
                    }).always(() => Vue.set(properties.$data, 'loading', false))
                }
            }
        })

        const properties = new Vue({
            el: "#properties_cards",
            mixins: [PropertyCardsMixin],
            mounted() {
                this.searchable = search
            }
        })
        
        search.search()
    }

    let captchaLoaded = false
    $(".captcha-refresh").click(
        () => {
            if (!captchaLoaded) {
                grecaptcha.render($('.g-recaptcha')[0], {
                    sitekey: $('.g-recaptcha').attr('data-sitekey')
                })

                captchaLoaded = true
            } else
                grecaptcha.reset()
        }
    )   
})