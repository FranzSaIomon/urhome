<template>
    <div>
        <label>{{label}}</label>
        <div class="multi-select">
            <button :data-value='option.value' v-for="option in options" class="btn btn-outline-secondary btn-sm" :key="option.value" @click.prevent="updateSelected">
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
                    this.values[this.name] = []
                    
                if (target.hasClass('active')) {
                    this.values[this.name] = this.values[this.name].filter(v => v != target.attr('data-value'))
                    target.removeClass('active')
                } else {
                    this.values[this.name].push(target.attr('data-value'))
                    target.addClass('active')
                }

            }
        }
    }
</script>
