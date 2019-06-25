export function property_update(FormMixin) {
    if ($("#vue-property-update").length) {
        const property_update = new Vue({
            el: "#vue-property-update",
            mixins: [FormMixin],
            data: {
                countries,
                errors: {},
                values: {},
                defaults: {},
                options: [],
                property_types: [],
                listing_types: [],
                years: [],
                success: undefined
            },
            created() {
                $.ajax({
                    url: "/api/amenity",
                    method: "GET",
                    success: (e) => {
                        $.each(e, (i, o) => this.options.push({
                            name: o.AmenityName,
                            value: o.id
                        }))
                    }
                })

                $.ajax({
                    url: "/api/property/types",
                    method: "GET",
                    success: (e) => {
                        $.each(e, (i, o) => this.property_types.push({
                            name: o.PropertyType,
                            value: o.id
                        }))
                    }
                })

                $.ajax({
                    url: "/api/listing/types",
                    method: "GET",
                    success: (e) => {
                        $.each(e, (i, o) => this.listing_types.push({
                            name: "For " + o.ListingType,
                            value: o.id
                        }))
                    }
                })

                for (let i = 1900; i <= new Date().getFullYear(); i++)
                    this.years.push({
                        name: i,
                        value: i,
                    })

                if (defaultValues) {
                    Object.assign(this.values, defaultValues)
                    Object.assign(this.defaults, defaultValues)
                }
            },
            mounted() {
                $("#update").confirmation({
                    onConfirm: this.update
                })

                $("#updateProperty").on('hidden.bs.modal', (e) => {
                    Vue.set(this.$data, 'values', this.defaults)
                    this.success = undefined;
                    this.errors = {}
                })

                $("#updateProperty").on('show.bs.modal', (e) => {
                    $("[data-toggle=confirmation]").confirmation("hide")
                })
            },
            methods: {
                update() {
                    let securities = this.getSecurities()
                    Vue.set(this.values, Object.keys(securities)[0], Object.values(securities)[0])

                    this.errors = {}
                    this.success = undefined

                    $("#vue-property-update").find("*").removeClass("is-invalid")

                    $("button#update .spinner-border").removeAttr('hidden')
                    $("button#update").attr("disabled", "disabled")
                    if (propertyID) {
                        $.ajax({
                                url: "/properties/update/" + propertyID,
                                data: this.values,
                                success: (e) => {
                                    console.log(e)
                                    this.success = "<b>Success!</b> You've successfully updated this property post. <a href='#' onclick='location.reload()'>Click here</a> to reload."
                                    Vue.set(this.$data, 'defaults', this.values)
                                },
                                error: (e) => {
                                    console.log(e)
                                    $.each(e.responseJSON.errors, (key, val) => Vue.set(this.errors, key, val))
                                }
                            })
                            .always((e) => {
                                $("button#update .spinner-border").attr('hidden', 'hidden')
                                $("button#update").removeAttr("disabled")
                            })
                    }
                }
            }
        })
    } else {
      return null
    }
}
