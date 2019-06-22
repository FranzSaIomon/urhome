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
    const countries = {"AD":"Andorra","AE":"United Arab Emirates","AF":"Afghanistan","AG":"Antigua and Barbuda","AI":"Anguilla","AL":"Albania","AM":"Armenia","AO":"Angola","AQ":"Antarctica","AR":"Argentina","AS":"American Samoa","AT":"Austria","AU":"Australia","AW":"Aruba","AX":"Aland Islands","AZ":"Azerbaijan","BA":"Bosnia and Herzegovina","BB":"Barbados","BD":"Bangladesh","BE":"Belgium","BF":"Burkina Faso","BG":"Bulgaria","BH":"Bahrain","BI":"Burundi","BJ":"Benin","BL":"Saint Barthelemy","BM":"Bermuda","BN":"Brunei","BO":"Bolivia","BQ":"Bonaire, Saint Eustatius and Saba ","BR":"Brazil","BS":"Bahamas","BT":"Bhutan","BV":"Bouvet Island","BW":"Botswana","BY":"Belarus","BZ":"Belize","CA":"Canada","CC":"Cocos Islands","CD":"Democratic Republic of the Congo","CF":"Central African Republic","CG":"Republic of the Congo","CH":"Switzerland","CI":"Ivory Coast","CK":"Cook Islands","CL":"Chile","CM":"Cameroon","CN":"China","CO":"Colombia","CR":"Costa Rica","CU":"Cuba","CV":"Cape Verde","CW":"Curacao","CX":"Christmas Island","CY":"Cyprus","CZ":"Czech Republic","DE":"Germany","DJ":"Djibouti","DK":"Denmark","DM":"Dominica","DO":"Dominican Republic","DZ":"Algeria","EC":"Ecuador","EE":"Estonia","EG":"Egypt","EH":"Western Sahara","ER":"Eritrea","ES":"Spain","ET":"Ethiopia","FI":"Finland","FJ":"Fiji","FK":"Falkland Islands","FM":"Micronesia","FO":"Faroe Islands","FR":"France","GA":"Gabon","GB":"United Kingdom","GD":"Grenada","GE":"Georgia","GF":"French Guiana","GG":"Guernsey","GH":"Ghana","GI":"Gibraltar","GL":"Greenland","GM":"Gambia","GN":"Guinea","GP":"Guadeloupe","GQ":"Equatorial Guinea","GR":"Greece","GS":"South Georgia and the South Sandwich Islands","GT":"Guatemala","GU":"Guam","GW":"Guinea-Bissau","GY":"Guyana","HK":"Hong Kong","HM":"Heard Island and McDonald Islands","HN":"Honduras","HR":"Croatia","HT":"Haiti","HU":"Hungary","ID":"Indonesia","IE":"Ireland","IL":"Israel","IM":"Isle of Man","IN":"India","IO":"British Indian Ocean Territory","IQ":"Iraq","IR":"Iran","IS":"Iceland","IT":"Italy","JE":"Jersey","JM":"Jamaica","JO":"Jordan","JP":"Japan","KE":"Kenya","KG":"Kyrgyzstan","KH":"Cambodia","KI":"Kiribati","KM":"Comoros","KN":"Saint Kitts and Nevis","KP":"North Korea","KR":"South Korea","KW":"Kuwait","KY":"Cayman Islands","KZ":"Kazakhstan","LA":"Laos","LB":"Lebanon","LC":"Saint Lucia","LI":"Liechtenstein","LK":"Sri Lanka","LR":"Liberia","LS":"Lesotho","LT":"Lithuania","LU":"Luxembourg","LV":"Latvia","LY":"Libya","MA":"Morocco","MC":"Monaco","MD":"Moldova","ME":"Montenegro","MF":"Saint Martin","MG":"Madagascar","MH":"Marshall Islands","MK":"Macedonia","ML":"Mali","MM":"Myanmar","MN":"Mongolia","MO":"Macao","MP":"Northern Mariana Islands","MQ":"Martinique","MR":"Mauritania","MS":"Montserrat","MT":"Malta","MU":"Mauritius","MV":"Maldives","MW":"Malawi","MX":"Mexico","MY":"Malaysia","MZ":"Mozambique","NA":"Namibia","NC":"New Caledonia","NE":"Niger","NF":"Norfolk Island","NG":"Nigeria","NI":"Nicaragua","NL":"Netherlands","NO":"Norway","NP":"Nepal","NR":"Nauru","NU":"Niue","NZ":"New Zealand","OM":"Oman","PA":"Panama","PE":"Peru","PF":"French Polynesia","PG":"Papua New Guinea","PH":"Philippines","PK":"Pakistan","PL":"Poland","PM":"Saint Pierre and Miquelon","PN":"Pitcairn","PR":"Puerto Rico","PS":"Palestinian Territory","PT":"Portugal","PW":"Palau","PY":"Paraguay","QA":"Qatar","RE":"Reunion","RO":"Romania","RS":"Serbia","RU":"Russia","RW":"Rwanda","SA":"Saudi Arabia","SB":"Solomon Islands","SC":"Seychelles","SD":"Sudan","SE":"Sweden","SG":"Singapore","SH":"Saint Helena","SI":"Slovenia","SJ":"Svalbard and Jan Mayen","SK":"Slovakia","SL":"Sierra Leone","SM":"San Marino","SN":"Senegal","SO":"Somalia","SR":"Suriname","SS":"South Sudan","ST":"Sao Tome and Principe","SV":"El Salvador","SX":"Sint Maarten","SY":"Syria","SZ":"Swaziland","TC":"Turks and Caicos Islands","TD":"Chad","TF":"French Southern Territories","TG":"Togo","TH":"Thailand","TJ":"Tajikistan","TK":"Tokelau","TL":"East Timor","TM":"Turkmenistan","TN":"Tunisia","TO":"Tonga","TR":"Turkey","TT":"Trinidad and Tobago","TV":"Tuvalu","TW":"Taiwan","TZ":"Tanzania","UA":"Ukraine","UG":"Uganda","UM":"United States Minor Outlying Islands","US":"United States","UY":"Uruguay","UZ":"Uzbekistan","VA":"Vatican","VC":"Saint Vincent and the Grenadines","VE":"Venezuela","VG":"British Virgin Islands","VI":"U.S. Virgin Islands","VN":"Vietnam","VU":"Vanuatu","WF":"Wallis and Futuna","WS":"Samoa","XK":"Kosovo","YE":"Yemen","YT":"Mayotte","ZA":"South Africa","ZM":"Zambia","ZW":"Zimbabwe"}
    
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
                countries,
                values: {
                    'email': 'aemard@example.com',
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
                        $("#vue-login button[type=submit]").attr('disabled', 'disabled')

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
                                this.success = undefined
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
                            $("#vue-login button[type=submit]").removeAttr('disabled')
                            grecaptcha.reset()
                        })
                    }
                },
                reset() {
                    let securities = this.getSecurities()
                    Vue.set(this.values, Object.keys(securities)[0], Object.values(securities)[0])

                    this.success = undefined
                    $("#vue-login button[type=submit] .spinner-border").removeAttr('hidden')
                    $("#vue-login button[type=submit]").attr('disabled', 'disabled')

                    $.ajax({
                        url: '/password/email',
                        method: "POST",
                        data: this.values,
                        success: (e) => {
                            this.success = e.status
                        },
                        error: (e) => {
                            $.each(e.responseJSON.errors, (key, val) => Vue.set(this.errors, key, val))
                            this.success = undefined
                        }
                    }).always((e) => {
                        $("#vue-login button[type=submit] .spinner-border").attr('hidden', 'hidden')
                        $("#vue-login button[type=submit]").removeAttr('disabled')
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
                countries,
                errors: {},
                success: null,
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
                    this.success = null
                    
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
                            $.each(e.responseJSON.errors, (key, val) => Vue.set(this.errors, key, val))
                            this.success = null
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

    if ($("#vue-property-update").length) {
        const property_update = new Vue({
            el: "#vue-property-update",
            mixins: [FormMixin],
            data: {
                countries,
                errors: {},
                values: {},
                defaults: {},
                options: [],
                property_types: [],
                listing_types: [],
                years: [],
                success: undefined
            },
            created() {
                $.ajax({
                    url: "/api/amenity",
                    method: "GET",
                    success: (e) => {
                        $.each(e, (i, o) => this.options.push({
                            name: o.AmenityName,
                            value: o.id
                        }))
                    }
                })

                $.ajax({
                    url: "/api/property/types",
                    method: "GET",
                    success: (e) => {
                        $.each(e, (i, o) => this.property_types.push({
                            name: o.PropertyType,
                            value: o.id
                        }))
                    }
                })

                $.ajax({
                    url: "/api/listing/types",
                    method: "GET",
                    success: (e) => {
                        $.each(e, (i, o) => this.listing_types.push({
                            name: "For " + o.ListingType,
                            value: o.id
                        }))
                    }
                })

                for (let i = 1900; i <= new Date().getFullYear(); i++)
                    this.years.push({
                        name: i,
                        value: i,
                    })

                if (defaultValues) {
                    Object.assign(this.values, defaultValues)
                    Object.assign(this.defaults, defaultValues)
                }
            },
            mounted() {
                $("#update").confirmation({
                    onConfirm: this.update
                })

                $("#updateProperty").on('hidden.bs.modal', (e) => {
                    Vue.set(this.$data, 'values', this.defaults)
                    this.success = undefined;
                    this.errors = {}
                })

                $("#updateProperty").on('show.bs.modal', (e) => {
                    $("[data-toggle=confirmation]").confirmation("hide")
                })
            },
            methods: {
                update() {
                    let securities = this.getSecurities()
                    Vue.set(this.values, Object.keys(securities)[0], Object.values(securities)[0])
                    
                    this.errors = {}
                    this.success = undefined

                    $("#vue-property-update").find("*").removeClass("is-invalid")

                    $("button#update .spinner-border").removeAttr('hidden')
                    $("button#update").attr("disabled", "disabled")
                    if (propertyID) {
                        $.ajax({
                            url: "/properties/update/" + propertyID,
                            data: this.values,
                            success: (e) => {
                                console.log(e)
                                this.success = "<b>Success!</b> You've successfully updated this property post. <a href='#' onclick='location.reload()'>Click here</a> to reload."
                                Vue.set(this.$data, 'defaults', this.values)
                            },
                            error: (e) => {
                                console.log(e)
                                $.each(e.responseJSON.errors, (key, val) => Vue.set(this.errors, key, val))
                            }
                        })
                        .always((e) => {
                            $("button#update .spinner-border").attr('hidden', 'hidden')
                            $("button#update").removeAttr("disabled")
                        })
                    }
                }
            }
        })
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