export function register(FormMixin, countries) {
    if ($("#vue-register").length) {
        const register = new Vue({
            el: "#vue-register",
            mixins: [FormMixin],
            data: {
                countries,
                errors: {},
                success: null,
                info: null,
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
                }],
                files: [],
                image: undefined,
            },
            updated() {
                if (this.values.UserType && this.values.UserType[0] == this.toggles[1].value) {
                    $("input[name=BrokerFiles]").change((e) => {
                        this.add_file($("input[name=BrokerFiles]")[0].files)
                    })
                } else {
                    $("input[name=BrokerFiles]").off('change')
                }
            },
            mounted() {
                $("input[name=ProfilePhoto]").change((e) => {
                    this.image = $("input[name=ProfilePhoto]")[0].files[0]
                    $("label[for=ProfilePhoto]").text(this.image.name)
                })
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
                    this.info = null
                    let fmd = new FormData()

                    $.each(value_copy, (key, obj) => {
                        fmd.append(key, obj)
                    })

                    $.each(this.files, (i, o) => {
                        fmd.append('file' + i, o.file)
                    })

                    fmd.append('image', this.image)

                    $("#vue-register button[type=submit] .spinner-border").removeAttr('hidden')
                    $("#vue-register button[type=submit]").attr("disabled", "disabled")

                    $.ajax({
                        url: '/register',
                        method: 'POST',
                        data: fmd,
                        headers: {
                            'X-CSRF-Token': this.values._token
                        },
                        enctype: 'multipart/form-data',
                        processData: false, 
                        contentType: false,
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
                },
                add_file(files) {
                    if (this.files.length < 3) {
                        $.each(files, (i, file) => {
                            if (!this.lookup_file(this.files, file)) {
                                let f = {
                                    id: this.files.length,
                                    file: file,
                                    name: file.name
                                }
    
                                if (this.files.length < 3 && f.file.size <= 5000000) {
                                    this.files.push(f)
                                } else {
                                    if (f.file.size > 5000000)
                                        this.info = "<b>Info: </b> You can only upload images with sizes up to 5MB."
                                    else
                                        this.info = "<b>Info: </b> You have reached the maximum number of allowable property files. Please remove some to add a new files."
                                    return false
                                }
                            }
                        })
                    } else {
                        this.info = "<b>Info: </b> You have reached the maximum number of allowable property images. Please remove some to add a new image."
                    }
                },
                remove_file(file) {
                    this.info = undefined
                    
                    let i = 0;
                    for (i = 0; i < this.files.length; i++)
                        if (this.files[i].id == file.id)
                            break

                    this.files.splice(i, 1)
                },
                lookup_file(array, file) {
                    $.each(array, (i, o) => {
                        if (o.file === file) {
                            return true
                        }
                    })

                    return false
                },
            }
        })
    } else {
      return null;
    }
}
