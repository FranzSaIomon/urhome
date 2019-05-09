<template>
    <div class="slider">
        <div ref="slider"></div>
        <div class="slider-labels">
            <span>{{start}}</span>
            <span>{{end}}</span>
        </div>
        <input type="hidden" :name="name" ref="value" :value="'[' + start + ',' + end + ']'">
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')

            /* In case no initial start and end range is given assume minmax is default */
            this.start = this.start || this.min
            this.end = this.end || this.max

            const slider = noUiSlider.create(this.$refs['slider'], {
                start: [this.start || this.min, this.end || this.max],
                step: this.steps || 1,
                connect: true,
                range: {
                    'min': this.min || 0,
                    'max': this.max || 10
                }
            }).on('slide', adjust.bind(this))

            function adjust(values, handle, unencoded, tap, positions) {
                this.start = parseInt(values[0])
                this.end = parseInt(values[1])
            }
        },
        data() {
            return {
                min: parseInt(this.$attrs['min']) || 0,
                max: parseInt(this.$attrs['max']) || 10,
                start: parseInt(this.$attrs['start']) || null,
                end: parseInt(this.$attrs['end']) || null,
                name: this.$attrs['name'],
            }
        }
    }
</script>