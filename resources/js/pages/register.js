export function register(FormMixin, countries) {
    if ($("#vue-register").length) {
        const register = new Vue({
            el: "#vue-register",
            mixins: [FormMixin],
            data: {
                countries,
                errors: {},
                success: null,
                values: {
                    FirstName: "Miguel",
                    LastName: "Quiambao",
                    BirthDate: "1998-03-31",
                    ContactNo: "09178510533",
                    LotNo: 123,
                    Street: "N. Domingo",
                    City: "San Juan",
                    Country: "PH",
                    email: "miguelalfonsoquiambao@gmail.com",
                    password: "password",
                    password_confirmation: "password",
                    UserType: [1],
                },
                toggles: [{
                    name: 'Client',
                    value: 1
                }, {
                    name: 'Broker',
                    value: 2
                }]
            },
            methods: {
                register() {
                    let securities = this.getSecurities()
                    Vue.set(this.values, Object.keys(securities)[0], Object.values(securities)[0])
                    Vue.set(this.values, Object.keys(securities)[1], Object.values(securities)[1])
                    
                    let value_copy = Object.assign({}, this.values)
                    value_copy.UserType = this.values.UserType[0]

                    this.errors = {}
                    this.success = null
                    $("#vue-register button[type=submit] .spinner-border").removeAttr('hidden')
                    $("#vue-register button[type=submit]").attr("disabled", "disabled")
                    $.ajax({
                        url: '/register',
                        method: 'POST',
                        data: value_copy,
                        success: (e) => {
                            this.success = "<b>Success!</b> You've successfully registered, please check your email for the verification link"
                        },
                        error: (e) => {
                            $.each(e.responseJSON.errors, (key, val) => Vue.set(this.errors, key, val))
                            this.success = null
                        }
                    }).always((e) => {
                        $("#vue-register button[type=submit] .spinner-border").attr('hidden', 'hidden')
                        $("#vue-register button[type=submit]").removeAttr("disabled")
                    })
                }
            }
        })
    } else {
      return null;
    }
}
