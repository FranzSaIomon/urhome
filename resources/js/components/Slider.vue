<template>
    <div class="slider">
        <div class="slider-header">
            <select class="custom-select custom-select-sm" v-if="minimums" @change="updateLimits" v-model="min">
                <option v-for="minimum in minimums" :value="minimum">{{returnDisplayValue(minimum)}}</option>
            </select>
            <label v-if="label">{{label}}</label>
            <select class="custom-select custom-select-sm" v-if="maximums" @change="updateLimits" v-model="max">
                <option v-for="maximum in maximums" :value="maximum">{{returnDisplayValue(maximum)}}</option>
            </select>
        </div>
        <div ref="slider"></div>
        <div class="slider-labels">
            <div>
                <b v-if="prefix">{{prefix}}</b>
                <span v-if="start < min"> {{commaDisplayValue(min, this.currency)}} </span>
                <span v-else>{{commaDisplayValue(start, this.currency)}}</span>
                <i v-if="suffix">{{suffix}}</i>
            </div>

            <div>
                <b v-if="prefix">{{prefix}}</b>
                <span v-if="end == max && !inclusive">{{commaDisplayValue(end, this.currency)}}+</span>
                <span v-else-if="end > max && !inclusive">{{commaDisplayValue(max, this.currency)}}+</span>
                <span v-else-if="end > max && inclusive">{{commaDisplayValue(max, this.currency)}}</span>
                <span v-else>{{commaDisplayValue(end, this.currency)}}</span>
                <i v-if="suffix">{{suffix}}</i>
            </div>
        </div>
        <input type="hidden" :name="name" ref="value" v-model="values[name]">
    </div>
</template>

<script>
    import CurrencyMixin from './mixins/CurrencyMixin';
    import InputMixin from './mixins/InputMixin';
    
    export default {
        mixins: [CurrencyMixin, InputMixin],
        data() {
            return {
                min: parseInt(this.$attrs['min']) || 0,
                max: parseInt(this.$attrs['max']) || 10,
                start: parseInt(this.$attrs['start']),
                end: parseInt(this.$attrs['end']),
                step: parseInt(this.$attrs['step']) || 1,
                name: this.$attrs['name'],
                label: this.$attrs['label'],
                maximums: this.$attrs['maximums'],
                minimums: this.$attrs['minimums'],
                inclusive: this.$attrs['inclusive'] || 'false',
                prefix: this.$attrs['prefix'],
                suffix: this.$attrs['suffix'],
                currency: this.$attrs['currency'] || 'false'
            }
        },
        created(){
            this.values[this.name] = [this.start || this.min, this.end || this.max]
        },
        mounted() {
            this.inclusive = (this.inclusive === 'true')
            this.currency = (this.currency === 'true')

            /* In case no initial start and end range is given assume minmax is default */
            this.start = this.start || this.min
            this.end = this.end || this.max

            /* If maximums or minimums exists, split into array and filter out all valid values */
            this.minimums = (this.minimums) ? this.minimums
                                .replace(/\s+/, '')
                                .split(',')
                                .reduce((prev, curr) => {
                                    let c = parseInt(curr)
                                    if (c)
                                        prev.push(c)

                                    return prev
                                }, [])
                            : this.minimums;

            this.maximums = (this.maximums) ? this.maximums
                                .replace(/\s+/gi, '')
                                .split(',')
                                .reduce((prev, curr) => {
                                    let c = parseInt(curr)
                                    if (c)
                                        prev.push(c)

                                    return prev
                                }, [])
                            : this.maximums;

            noUiSlider.create(this.$refs['slider'], {
                start: [this.start || this.min, this.end || this.max],
                step: this.step,
                connect: true,
                range: {
                    'min': this.min,
                    'max': this.max
                }
            }).on('slide', adjust.bind(this))

            function adjust(values, handle, unencoded, tap, positions) {
                this.start = parseInt(values[0])
                this.end = parseInt(values[1])

                this.values[this.name][0] = this.start
                this.values[this.name][1] = this.end
            }
        },
        methods: {
            updateLimits(e) {

                /* Update input in case current values are out of bounds */
                this.start = (this.min > this.start) ? this.min : this.start;
                this.end = (this.max < this.end) ? this.max : this.end;

                this.$refs['slider'].noUiSlider.updateOptions({
                    range: {
                        min: this.min,
                        max: this.max
                    }
                })
            }
        },
    }
</script>