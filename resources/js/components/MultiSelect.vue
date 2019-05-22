<template>
    <div class="form-group">
        <div class="d-flex justify-content-between">
            <label>{{label}}</label>
            <a class="" href="#" @click.prevent="reset">Reset</a>
        </div>
        <div class="multi-select" ref="multi-select">
            <button :data-value='option.value' v-for="option in options" :class="'btn btn-outline-secondary btn-sm ' + ((values[name] && values[name].indexOf(''+option.value) != -1) ? 'active' : '')" :key="option.value" @click.prevent="updateSelected">
                {{option.name}}
            </button>
        </div>
        <input type="hidden" :name="name" v-model="values[name]" ref="value">    
    </div>
</template>

<script>
    import InputMixin from './mixins/InputMixin';
    
    export default {
        mixins: [InputMixin],
        mounted() {
            
        },
        data() {
            return {
                name: this.$attrs['name'],
                label: this.$attrs['label'],
            }
        },
        methods: {
            updateSelected(e) {
                let target = $(e.target);
                if (!this.values[this.name])
                    Vue.set(this.values, this.name, [])
                
                if (target.hasClass('active')) {
                    Vue.set(this.values, this.name, this.values[this.name].filter(v => v != target.attr('data-value')))
                    target.removeClass('active')
                } else {
                    Vue.set(this.values, this.name, [target.attr('data-value'), ...this.values[this.name]])
                    target.addClass('active')
                }

            },
            reset() {
                this.values[this.name] = []
                $(this.$refs['multi-select']).find("button").removeClass('active')
            }
        }
    }
</script>
