export default {
    props: {
        errors: Object,
        values: Object,
        options: {
            type: Array,
            required: false,
            default: () => {return [];}
        }
    },
}