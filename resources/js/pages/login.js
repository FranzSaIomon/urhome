export function login(FormMixin) {
    if ($("#vue-login").length) {
        return new Vue({
            el: "#vue-login",
            data: {
                errors: {},
                values: {
                    'email': 'aemard@example.com',
                    'password': 'password'
                },
                loginForm: true,
                formChanged: false,
                success: undefined,
            },
            mixins: [FormMixin],
            updated() {
                if (this.formChanged && this.loginForm) {
                    this.formChanged = false

                    grecaptcha.render($('.g-recaptcha')[0], {
                        sitekey: this.sitekey
                    })
                }
            },
            methods: {
                login() {
                    // Remember: https://vuejs.org/v2/guide/list.html#Caveats
                    if (this.loginForm) {
                        let securities = this.getSecurities()
                        Vue.set(this.values, Object.keys(securities)[0], Object.values(securities)[0])
                        Vue.set(this.values, Object.keys(securities)[1], Object.values(securities)[1])

                        this.errors = {}
                        this.success = undefined
                        $("#vue-login button[type=submit] .spinner-border").removeAttr('hidden')
                        $("#vue-login button[type=submit]").attr('disabled', 'disabled')

                        $.ajax({
                            url: '/login',
                            method: "POST",
                            data: this.values,
                            success: (e) => {
                                this.success = "<b>Success!</b> You've successfully logged in, please wait to be redirected..."
                                location.reload()
                            },
                            error: (e) => {
                                $.each(e.responseJSON.errors, (key, val) => Vue.set(this.errors, key, val))
                                this.success = undefined
                                if (e.responseJSON.errors["g-recaptcha-response"]) {
                                    let captcha_elem = $(this.$el).find('.g-recaptcha');

                                    captcha_elem.find('> div')
                                        .css("border", '1px solid #e3342f')

                                    captcha_elem.find('+.invalid-feedback')
                                        .css('display', 'block')
                                        .text(e.responseJSON.errors['g-recaptcha-response'])
                                }
                            }
                        }).always((e) => {
                            $("#vue-login button[type=submit] .spinner-border").attr('hidden', 'hidden')
                            $("#vue-login button[type=submit]").removeAttr('disabled')
                            grecaptcha.reset()
                        })
                    }
                },
                reset() {
                    let securities = this.getSecurities()
                    Vue.set(this.values, Object.keys(securities)[0], Object.values(securities)[0])

                    this.success = undefined
                    $("#vue-login button[type=submit] .spinner-border").removeAttr('hidden')
                    $("#vue-login button[type=submit]").attr('disabled', 'disabled')

                    $.ajax({
                        url: '/password/email',
                        method: "POST",
                        data: this.values,
                        success: (e) => {
                            this.success = e.status
                        },
                        error: (e) => {
                            $.each(e.responseJSON.errors, (key, val) => Vue.set(this.errors, key, val))
                            this.success = undefined
                        }
                    }).always((e) => {
                        $("#vue-login button[type=submit] .spinner-border").attr('hidden', 'hidden')
                        $("#vue-login button[type=submit]").removeAttr('disabled')
                    })
                },
                changeForm() {
                    this.loginForm = !this.loginForm
                    this.formChanged = true
                    this.success = undefined
                    this.errors = {}
                }
            }
        })
    } else {
      return null;
    }
}
