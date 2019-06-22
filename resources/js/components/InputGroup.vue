<template>
    <div class="form-group">
        <label :for="id" v-if="label && type.toLowerCase() != 'check'">{{label}}</label>
                
        <select :name="name" :class="{
                    'custom-select': true,
                    'custom-select-sm': true,
                    'is-invalid': errors[name]
                }"
                v-if="type.toLowerCase() =='select'" 
                v-model="values[name]" :id="id" :required="required ? true : false">
            <option v-for="option in options" :value="option.value" :key="option.name">{{option.name}}</option>
        </select>

        <div class="country-select" v-else-if="type.toLowerCase() =='country'">
            <span ref="country-flag" v-if="values[name]" :class="'flag-icon flag-icon-' + values[name].toLowerCase()"></span>
            <span ref="country-flag" v-else></span>
            <select :class="{
                    'custom-select': true,
                    'custom-select-sm': true,
                    'is-invalid': errors[name],
                }"
                :name="name" v-model="values[name]" :id="id" ref="country" :required="required ? true : false">
                <option v-for="(k, v) in countries" :value="v" :key="k">{{k}}</option>
            </select>
        </div>

        <textarea :class="{
                    'form-control': true,
                    'form-control-sm': true,
                    'is-invalid': errors[name]
                }" :name="name" :id="id" v-model="values[name]" :placeholder="placeholder" 
            :required="required ? true : false" v-else-if="type.toLowerCase() == 'multitext'"></textarea>

        <div class="form-check" v-else-if="type.toLowerCase() == 'check'">
            <input type="checkbox" v-model="values[name]" :name="name" :id="id" class="form-check-input">
            <label class="form-check-label" :for="id">{{label}}</label>
        </div>

        <input :type="type" :name="name"
               :class="{
                    'form-control': true,
                    'form-control-sm': true,
                    'is-invalid': errors[name]
                }"
                v-model="values[name]"
                v-else
                :placeholder="placeholder" 
                :required="required ? true : false"/>

        <span class="invalid-feedback" role="alert" v-for="error in errors[name]" :key="error">{{error}}</span>
    </div>
</template>

<script>
    import InputMixin from './mixins/InputMixin';
    
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
                id: this.$attrs['id'] || '',
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