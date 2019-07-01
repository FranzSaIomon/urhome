export function listing_add(FormMixin, countries) {
    if ($("#vue-listing-add").length) {
        return new Vue({
            el: '#vue-listing-add',
            mixins: [FormMixin],
            data: {
                countries,
                errors: {},
                values: {"Name":"Test Property Name","Developer":"Test Developer","Description":"Test","LotNo":"12","Street":"Street 23","City":"Manila","Country":"AM","PropertyTypeID":1,"ListingTypeID":1,"Price":"1500","YearBuilt":2019,"FloorArea":"123","LotArea":"123","NumberOfBedrooms":"12","NumberOfBathrooms":"12","CapacityOfGarage":"3","Amenities":["7","2","3"]},
                defaults: {},
                options: [],
                property_types: [],
                listing_types: [],
                years: [],
                images: [],
                files: [],
                info: undefined,
                success: undefined,
                error: undefined,
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
                $("input[name=PropertyImages]").change((e) => {
                    this.add_image($("input[name=PropertyImages]")[0].files)
                })
                $("input[name=PropertyFiles]").change((e) => {
                    this.add_file($("input[name=PropertyFiles]")[0].files)
                })
            },
            methods: {
                post() {
                    let securities = this.getSecurities()
                    Vue.set(this.values, Object.keys(securities)[0], Object.values(securities)[0])
                    Vue.set(this.values, Object.keys(securities)[1], Object.values(securities)[1])
                    let values = Object.assign({}, this.values)
                    let images = []

                    this.success = undefined
                    this.error = undefined
                    this.info = undefined
                    let fmd = new FormData()
                    $.each(this.values, (key, obj) => {
                        fmd.append(key, obj)
                    })

                    $.each(this.images, (i, o) => {
                        fmd.append('image' + i, o.file)
                    })

                    $.each(this.files, (i, o) => {
                        fmd.append('file' + i, o.file)
                    })
                    
                    $.ajax({
                        url: "/properties/post",
                        method: "POST",
                        data: fmd,
                        headers: {
                            'X-CSRF-Token': values._token
                        },
                        enctype: 'multipart/form-data',
                        processData: false, 
                        contentType: false,
                        success: (e) => {
                            this.success = e.message
                            this.values = {}
                            this.files = {}
                            this.images = {}
                        },
                        error: (e) => {
                            if (e.responseJSON && e.responseJSON.errors) {
                                $.each(e.responseJSON.errors, (key, val) => Vue.set(this.errors, key, val))
                            } else if (e.message)
                                this.error = e.message
                        }
                    })
                },
                add_image(files) {
                    if (this.images.length < 10) {
                        $.each(files, (i, file) => {
                            if (!this.lookup_file(this.images, file)) {
                                let image = {
                                    id: this.images.length,
                                    file: file,
                                    src: ""
                                }
    
                                this.get_preview(image)
    
                                if (this.images.length < 10 && image.file.size <= 3000000) {
                                    this.images.push(image)
                                } else {
                                    if (image.file.size > 3000000)
                                        this.info = "<b>Info: </b> You can only upload images with sizes up to 3MB."
                                    else
                                        this.info = "<b>Info: </b> You have reached the maximum number of allowable property images. Please remove some to add a new image."
                                    return false
                                }
                            }
                        })
                    } else {
                        this.info = "<b>Info: </b> You have reached the maximum number of allowable property images. Please remove some to add a new image."
                    }
                },
                remove_image(image) {
                    this.info = undefined
                    
                    let i = 0;
                    for (i = 0; i < this.images.length; i++)
                        if (this.images[i].id == image.id)
                            break

                    this.images.splice(i, 1)
                },
                add_file(files) {
                    if (this.files.length < 5) {
                        $.each(files, (i, file) => {
                            if (!this.lookup_file(this.files, file)) {
                                let f = {
                                    id: this.files.length,
                                    file: file,
                                    name: file.name
                                }
    
                                if (this.files.length < 5 && f.file.size <= 5000000) {
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
                get_preview(image) {
                    let reader = new FileReader()

                    reader.onload = (e) => {
                        image.src = e.target.result
                    }

                    reader.readAsDataURL(image.file)
                }
            }
        })
    }

    return null
}