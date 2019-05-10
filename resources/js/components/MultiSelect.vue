<template>
    <div>
        <label>{{label}}</label>
        <div class="multi-select">
            <button :data-value='option.value' v-for="option in options" class="btn btn-outline-secondary btn-sm" :key="option.value" @click.prevent="updateSelected">
                {{option.name}}
            </button>
        </div>
        <input type="hidden" :name="name" :value="selected" ref="value">    
    </div>
</template>

<script>
    export default {
        props: {
            options: {
                type: Array
            }
        },
        mounted() {

        },
        data() {
            return {
                name: this.$attrs['name'],
                label: this.$attrs['label'],
                selected: []
            }
        },
        methods: {
            updateSelected(e) {
                let target = $(e.target);

                if (target.hasClass('active')) {
                    this.selected = this.selected.filter(v => v != target.attr('data-value'))
                    target.removeClass('active')
                } else {
                    this.selected.push(target.attr('data-value'))
                    target.addClass('active')
                }

            }
        }
    }
</script>
