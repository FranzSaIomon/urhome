export default {
    methods: {
        returnDisplayValue(val) {
            if (val < 1000)
                return val
            else if (val < 1000000) 
                return (val / 1000) + "K"
            else if (val < 1000000000)
                return (val / 1000000) + "M"
            else
                return (val / 1000000000) + "B"
        },
        commaDisplayValue (val, hasDeci=true) {
            return val.toFixed(hasDeci ? 2 : 0).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }
    }
}