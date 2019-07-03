export default {
    props: {
        sitekey: {
            type: String,
            default: "6LfOcKIUAAAAAF-EhW6-UjKgi_y3IUdRErtqcT5N"
        }
    },
    methods: {
        getSecurities() {
            return {
                _token: $(this.$el).find("[name=_token]").val() || $("[name=csrf-token]").attr("content"),
                'g-recaptcha-response': $(this.$el).find("[name=g-recaptcha-response]").val()
            }
        }
    }
}