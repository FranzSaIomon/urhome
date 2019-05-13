<template>
    <div :name='name' :class="'toggle-buttons ' + ( (type && type.toLowerCase() == 'joined') ? 'joined' : '')" :id="id">
        <label v-if="label">{{label}}</label>
        <div class="buttons">
            <button :value="toggle.value" :class="{'active': actives.indexOf(toggle.value) != -1}" v-for="toggle in toggles" :key="toggle.value" @click.prevent="toggleValue(toggle)">{{toggle.name}}</button>
        </div> 
        <div class="text-muted small" style="text-align: center">You have selected: {{selectedName}}</div>
        <input type="hidden" :name="name" :value="actives">
    </div>
</template>

<script>
    import InputMixin from './mixins/InputMixin';
    
    export default{
        mixins: [InputMixin],
        props: {
            toggles: {},
            'default-value': [String, Number],
            'default-name': String,
        },
        data() {
            return {
                actives: [],
                selectedName: "",
                multiple: this.$attrs['multiple'] != undefined,
                required: this.$attrs['required'] != undefined,
                name: this.$attrs['name'] || 'ToggleButton',
                type: this.$attrs['type'] || false,
                id: this.$attrs['id'] || '',
                label: this.$attrs['label'] || '',
            }
        },
        created() {
            if (this.defaultValue) {
                this.actives = [this.defaultValue]
                for (let i = 0; i < this.toggles.length; i++)
                    if (this.toggles[i].value == this.defaultValue) {
                        this.selectedName = this.toggles[i].name
                        break;
                    } else if (i == this.toggles.length - 1) {
                        this.selectedName = this.defaultName || 'Default'
                    }

                if (this.toggles.length == 0)
                    this.selectedName = this.defaultName || 'Default'
            }
        },
        methods:{
            toggleValue(toggle) {
                let value = toggle.value;

                if (!this.values[this.name])
                    this.values[this.name] = []

                let valIndex = this.values[this.name].indexOf(value)

                if (valIndex == -1) {
                    if (this.multiple) {
                        this.actives.push(value)
                        this.values[this.name].push(value)
                    } else {
                        this.actives = this.values[this.name] = [value];
                    }
                    
                    this.selectedName = ""
                    for (let i = 0 ; i < this.actives.length; i++)
                        for (let j = 0; j < this.toggles.length; j++)
                            if (this.toggles[j].value == this.actives[i])
                                this.selectedName = this.toggles[j].name + ((i < this.actives.length - 1) ? ', ' : '')
                } else {
                    if (this.required) {
                        let btn = $('div[name=' + this.name + '] button[value=' + value + ']');
                        
                        if (btn.next().length == 0)
                            btn = btn.prev()
                        else btn = btn.next()

                        if ((this.multiple && this.values[this.name].length == 1) || (!this.multiple && this.required)) { // must have at least one value
                            this.values[this.name] = [parseInt(btn.attr('value'))];
                            this.actives = [parseInt(btn.attr('value'))];
                        }
                    } else {
                        if (this.multiple) {
                            this.actives.splice(valIndex, 1)
                            this.values[this.name].splice(valIndex, 1)
                        } else
                            this.actives = this.values[this.name] = [];

                        if (this.actives.length == 0) {
                            this.actives = this.values[this.name] = [this.defaultValue]
                            this.selectedName = this.defaultName || 'Default'
                        }
                    }
                }
            }
        }
    }
</script>