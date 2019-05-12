<template>
    <div :name='name' :class="'toggle-buttons ' + ( (type.toLowerCase() == 'joined') ? 'joined' : '')" :id="id">
        <label v-if="label">{{label}}</label>
        <div class="buttons">
            <button :value="toggle.value" :class="{'active': actives.indexOf(toggle.value) != -1}" v-for="toggle in toggles" :key="toggle.value" @click.prevent="toggleValue(toggle)">{{toggle.name}}</button>
        </div> 
        <div class="text-muted small" style="text-align: center">You have selected: {{selectedName}}</div>
    </div>
</template>

<script>
    import InputMixin from './mixins/InputMixin';
    
    export default{
        mixins: [InputMixin],
        props: {
            toggles: {}
        },
        data() {
            return {
                actives: [1],
                selectedName: "Client",
                multiple: this.$attrs['multiple'] != undefined,
                required: this.$attrs['required'] != undefined,
                name: this.$attrs['name'] || 'ToggleButton',
                type: this.$attrs['type'] || false,
                id: this.$attrs['id'] || '',
                label: this.$attrs['label'] || ''
            }
        },
        mounted() {
            
        },
        methods:{
            toggleValue(toggle) {
                let value = toggle.value;
                this.selectedName = toggle.name

                if (!this.values[this.name])
                    this.values[this.name] = [];

                let valIndex = this.values[this.name].indexOf(value)

                if (valIndex == -1) {
                    if (this.multiple) {
                        this.actives.push(value)
                        this.values[this.name].push(value)
                    } else
                        this.actives = this.values[this.name] = [value];
                } else {
                    let btn = $('div[name=' + this.name + '] button[value=' + value + ']');
                    
                    if (btn.next().length == 0)
                        btn = btn.prev()
                    else btn = btn.next()

                    if (this.required) {
                        if ((this.multiple && this.values[this.name].length == 1) || (!this.multiple && this.required)) { // must have at least one value
                            this.values[this.name] = [parseInt(btn.attr('value'))];
                            this.actives = [parseInt(btn.attr('value'))];
                        }
                    } else
                        if (this.multiple) {
                            this.actives.splice(valIndex, 1)
                            this.values[this.name].splice(valIndex, 1)
                        } else
                            this.actives = this.values[this.name] = [];
                }
            }
        }
    }
</script>