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
        commaDisplayValue (val) {
            return (val && val > 999) ? 
                (val + '').split('').reduceRight((p, c, i, a) => {
                    let rIndex = a.length - i;
                    if (rIndex % 3 == 0 && rIndex != 0 && rIndex != a.length)
                        p = ',' + c + p
                    else
                        p = c + '' + p
                    return p;
                }, "") 
            : val
        }
    }
}