export default {
    methods: {
        getSecurities() {
            return {
                _token: $(this.$el).children("[name=_token]").val(),
                'g-recaptcha-response': $(this.$el).find("[name=g-recaptcha-response]").val()
            }
        }
    }
}