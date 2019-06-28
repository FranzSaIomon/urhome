export function listing_add(FormMixin, countries) {
    if ($("#vue-listing-add").length) {
        return new Vue({
            el: '#vue-listing-add',
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
                panoramas: [],
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
            },
            mounted() {
                $("input[name=PropertyPanoramas]").change((e) => {
                    this.add_panorama($("input[name=PropertyPanoramas]")[0].files)
                })
            },
            methods: {
                add_panorama(files) {
                    $.each(files, (i, file) => {
                        if (!this.lookup_photo(this.panoramas, file)) {
                            let panorama = {
                                name: "New Panorama",
                                file: file,
                                src: ""
                            }

                            this.get_preview(panorama)

                            this.panoramas.push(panorama)
                        }
                    })

                    console.log(this.panoramas)
                },
                remove_panorama(panorama) {
                    for (i = 0; i < this.panoramas; i++)
                        if (this.panoramas[i] == panorama)
                            delete this.panoramas[i]
                    
                },
                lookup_photo(array, file) {
                    $.each(array, (i, o) => {
                        if (o.file === file) {
                            return true
                        }
                    })

                    return false
                },
                get_preview(panorama) {
                    let reader = new FileReader()

                    reader.onload = (e) => {
                        panorama.src = e.target.result
                    }

                    reader.readAsDataURL(panorama.file)
                }
            }
        })
    }

    return null
}