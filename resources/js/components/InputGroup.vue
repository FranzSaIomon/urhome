<template>
    <div class="form-group">
        <label :for="id" v-if="label">{{label}}</label>
        <input :type="type" :name="name"
               :class="{
                    'form-control': true,
                    'form-control-sm': true,
                    'is-invalid': errors[name]
                }"
                v-if="type.toLowerCase() != 'select' && type.toLowerCase() != 'country'" v-model="values[name]"
                :placeholder="placeholder" 
                :required="required ? true : false" value="value"/>
                
        <select :name="name" :class="{
                    'custom-select': true,
                    'custom-select-sm': true,
                    'is-invalid': errors[name]
                }"
                v-if="type.toLowerCase() =='select'" 
                v-model="values[name]" :id="id" :required="required ? true : false">
            <option v-for="option in options" :value="option.value" :key="option.name" v-if="v == value">{{option.name}}</option>
            <option v-for="option in options" :value="option.value" :key="option.name" v-else>{{option.name}}</option>
        </select>

        <div class="country-select" v-if="type.toLowerCase() =='country'">
            <span ref="country-flag" v-if="values[name]" :class="'flag-icon flag-icon-' + values[name].toLowerCase()"></span>
            <span ref="country-flag" v-else></span>
            <select :class="{
                    'custom-select': true,
                    'custom-select-sm': true,
                    'is-invalid': errors[name],
                }"
                :name="name" v-model="values[name]" :id="id" ref="country" :required="required ? true : false">
                <option v-for="(k, v) in countries" :value="v" :key="k" selected v-if="v == value">{{k}}</option>
                <option v-for="(k, v) in countries" :value="v" :key="k" v-else>{{k}}</option>
            </select>
        </div>

        <span class="invalid-feedback" role="alert" v-for="error in errors[name]" :key="error">{{error}}</span>
    </div>
</template>

<script>
    import InputMixin from './mixins/InputMixin';
    
    const countries = {"AD":"Andorra","AE":"United Arab Emirates","AF":"Afghanistan","AG":"Antigua and Barbuda","AI":"Anguilla","AL":"Albania","AM":"Armenia","AO":"Angola","AQ":"Antarctica","AR":"Argentina","AS":"American Samoa","AT":"Austria","AU":"Australia","AW":"Aruba","AX":"Aland Islands","AZ":"Azerbaijan","BA":"Bosnia and Herzegovina","BB":"Barbados","BD":"Bangladesh","BE":"Belgium","BF":"Burkina Faso","BG":"Bulgaria","BH":"Bahrain","BI":"Burundi","BJ":"Benin","BL":"Saint Barthelemy","BM":"Bermuda","BN":"Brunei","BO":"Bolivia","BQ":"Bonaire, Saint Eustatius and Saba ","BR":"Brazil","BS":"Bahamas","BT":"Bhutan","BV":"Bouvet Island","BW":"Botswana","BY":"Belarus","BZ":"Belize","CA":"Canada","CC":"Cocos Islands","CD":"Democratic Republic of the Congo","CF":"Central African Republic","CG":"Republic of the Congo","CH":"Switzerland","CI":"Ivory Coast","CK":"Cook Islands","CL":"Chile","CM":"Cameroon","CN":"China","CO":"Colombia","CR":"Costa Rica","CU":"Cuba","CV":"Cape Verde","CW":"Curacao","CX":"Christmas Island","CY":"Cyprus","CZ":"Czech Republic","DE":"Germany","DJ":"Djibouti","DK":"Denmark","DM":"Dominica","DO":"Dominican Republic","DZ":"Algeria","EC":"Ecuador","EE":"Estonia","EG":"Egypt","EH":"Western Sahara","ER":"Eritrea","ES":"Spain","ET":"Ethiopia","FI":"Finland","FJ":"Fiji","FK":"Falkland Islands","FM":"Micronesia","FO":"Faroe Islands","FR":"France","GA":"Gabon","GB":"United Kingdom","GD":"Grenada","GE":"Georgia","GF":"French Guiana","GG":"Guernsey","GH":"Ghana","GI":"Gibraltar","GL":"Greenland","GM":"Gambia","GN":"Guinea","GP":"Guadeloupe","GQ":"Equatorial Guinea","GR":"Greece","GS":"South Georgia and the South Sandwich Islands","GT":"Guatemala","GU":"Guam","GW":"Guinea-Bissau","GY":"Guyana","HK":"Hong Kong","HM":"Heard Island and McDonald Islands","HN":"Honduras","HR":"Croatia","HT":"Haiti","HU":"Hungary","ID":"Indonesia","IE":"Ireland","IL":"Israel","IM":"Isle of Man","IN":"India","IO":"British Indian Ocean Territory","IQ":"Iraq","IR":"Iran","IS":"Iceland","IT":"Italy","JE":"Jersey","JM":"Jamaica","JO":"Jordan","JP":"Japan","KE":"Kenya","KG":"Kyrgyzstan","KH":"Cambodia","KI":"Kiribati","KM":"Comoros","KN":"Saint Kitts and Nevis","KP":"North Korea","KR":"South Korea","KW":"Kuwait","KY":"Cayman Islands","KZ":"Kazakhstan","LA":"Laos","LB":"Lebanon","LC":"Saint Lucia","LI":"Liechtenstein","LK":"Sri Lanka","LR":"Liberia","LS":"Lesotho","LT":"Lithuania","LU":"Luxembourg","LV":"Latvia","LY":"Libya","MA":"Morocco","MC":"Monaco","MD":"Moldova","ME":"Montenegro","MF":"Saint Martin","MG":"Madagascar","MH":"Marshall Islands","MK":"Macedonia","ML":"Mali","MM":"Myanmar","MN":"Mongolia","MO":"Macao","MP":"Northern Mariana Islands","MQ":"Martinique","MR":"Mauritania","MS":"Montserrat","MT":"Malta","MU":"Mauritius","MV":"Maldives","MW":"Malawi","MX":"Mexico","MY":"Malaysia","MZ":"Mozambique","NA":"Namibia","NC":"New Caledonia","NE":"Niger","NF":"Norfolk Island","NG":"Nigeria","NI":"Nicaragua","NL":"Netherlands","NO":"Norway","NP":"Nepal","NR":"Nauru","NU":"Niue","NZ":"New Zealand","OM":"Oman","PA":"Panama","PE":"Peru","PF":"French Polynesia","PG":"Papua New Guinea","PH":"Philippines","PK":"Pakistan","PL":"Poland","PM":"Saint Pierre and Miquelon","PN":"Pitcairn","PR":"Puerto Rico","PS":"Palestinian Territory","PT":"Portugal","PW":"Palau","PY":"Paraguay","QA":"Qatar","RE":"Reunion","RO":"Romania","RS":"Serbia","RU":"Russia","RW":"Rwanda","SA":"Saudi Arabia","SB":"Solomon Islands","SC":"Seychelles","SD":"Sudan","SE":"Sweden","SG":"Singapore","SH":"Saint Helena","SI":"Slovenia","SJ":"Svalbard and Jan Mayen","SK":"Slovakia","SL":"Sierra Leone","SM":"San Marino","SN":"Senegal","SO":"Somalia","SR":"Suriname","SS":"South Sudan","ST":"Sao Tome and Principe","SV":"El Salvador","SX":"Sint Maarten","SY":"Syria","SZ":"Swaziland","TC":"Turks and Caicos Islands","TD":"Chad","TF":"French Southern Territories","TG":"Togo","TH":"Thailand","TJ":"Tajikistan","TK":"Tokelau","TL":"East Timor","TM":"Turkmenistan","TN":"Tunisia","TO":"Tonga","TR":"Turkey","TT":"Trinidad and Tobago","TV":"Tuvalu","TW":"Taiwan","TZ":"Tanzania","UA":"Ukraine","UG":"Uganda","UM":"United States Minor Outlying Islands","US":"United States","UY":"Uruguay","UZ":"Uzbekistan","VA":"Vatican","VC":"Saint Vincent and the Grenadines","VE":"Venezuela","VG":"British Virgin Islands","VI":"U.S. Virgin Islands","VN":"Vietnam","VU":"Vanuatu","WF":"Wallis and Futuna","WS":"Samoa","XK":"Kosovo","YE":"Yemen","YT":"Mayotte","ZA":"South Africa","ZM":"Zambia","ZW":"Zimbabwe"}
    export default {
        mixins: [InputMixin],
        data() {
            return {
                name: this.$attrs['name'] || '',
                type: this.$attrs['type'] || 'text',
                label: this.$attrs['label'] || '',
                placeholder: this.$attrs['placeholder'] || '',
                value: this.$attrs["value"],
                required: this.$attrs['required'] != undefined,
                id: '',
                countries,
            }
        },
        mounted() {
            if (this.type === "country") {
                let select = $(this.$refs['country']);
                let flag = $(this.$refs['country-flag']);
                
                if (this.placeholder.length != 0) {
                    if (!this.values[this.name])
                        select.append("<option selected disabled>" + this.placeholder + "</option>")
                    else
                        select.append("<option disabled>" + this.placeholder + "</option>")
                }

                // $.each(countries, (k, v) => select.append('<option value="' + k + '">' + v + '</option>'))

                select.on('change', (e) => {
                    flag.removeClass().addClass("flag-icon flag-icon-" + e.target.value.toLowerCase())
                })
            }
        },
        methods: {
        }
    }
</script>