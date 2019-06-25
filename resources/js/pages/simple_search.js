export function simple_search(FormMixin, PropertyCardsMixin) {
    if ($("#vue-simple-search").length && $("#properties_cards").length) {
        const search = new Vue({
            el: "#vue-simple-search",
            mixins: [FormMixin],
            data: {
                toggles: [],
                options: [],
                values: {},
                errors: {},
                page: 1,
                shown: false,
                ignoreAdvanced: $.urlParam('ignoreAdvanced') ? true : false,
                lastPage: 1
            },
            created() {
                $.ajax({
                    method: "GET",
                    url: '/api/property/types',
                }).always((e) => {
                    $.each(e, (i, o) => {
                        this.options.push({
                            name: o.PropertyType,
                            value: o.id
                        })
                    })
                })

                $.ajax({
                    method: "GET",
                    url: '/api/listing/types',
                }).always((e) => {
                    $.each(e, (i, o) => {
                        this.toggles.push({
                            name: "For " + o.ListingType,
                            value: o.id
                        })
                    })
                })
            },
            mounted() {
                let range = [
                    "NumberOfBedrooms", "NumberOfBathrooms", "Price",
                    "LotArea", "FloorArea"
                ]

                let string = ["query", "location"]

                $.each(range, (i, v) => {
                    if ($.urlParam(v)) {
                        let values = decodeURIComponent($.urlParam(v)).split(',')
                        this.values[v][0] = parseInt(values[0], 10)
                        this.values[v][1] = parseInt(values[1], 10)

                        this.$refs[v].start = this.values[v][0]
                        this.$refs[v].end = this.values[v][1]

                        if (this.$refs[v].maximums)
                            this.$refs[v].max = this.$refs[v].maximums.find((el) => {
                                return this.values[v][1] <= el
                            })

                        this.$refs[v].updateLimits()
                        this.$refs[v].updateStart()
                    }
                })

                $.each(string, (i, v) => {
                    if ($.urlParam(v))
                        Vue.set(this.values, v, decodeURIComponent($.urlParam(v)))
                })

                if ($.urlParam('type'))
                    Vue.set(this.values, 'type', decodeURIComponent($.urlParam('type')).split(","))

                if ($.urlParam('purpose'))
                    Vue.set(this.values, 'purpose', decodeURIComponent($.urlParam('purpose')))
            },
            methods: {
                search(clear) {
                    if (clear) {
                        this.page = 1
                        Vue.set(properties.$data, 'cards', [])
                    }

                    Vue.set(properties.$data, 'loading', true)

                    let blacklist = [
                        "NumberOfBedrooms", "NumberOfBathrooms", "Price",
                        "LotArea", "FloorArea"
                    ]

                    let nonAdvanced = {}

                    for (let key in this.values)
                        if (blacklist.indexOf(key) == -1)
                            nonAdvanced[key] = this.values[key]
                    
                    this.values["page"] = this.page
                    nonAdvanced["page"] = this.page
                    $.ajax({
                        url: "/api/property/paginate",
                        method: "GET",
                        data: !this.ignoreAdvanced ? this.values : nonAdvanced,
                        success: (e) => {
                            if (e.data && e.data.length) {
                                console.log(this.values)
                                Vue.set(properties.$data, 'resultCount', e.total)

                                $.each(e.data, (i, o) => properties.cards.push(o))
                                this.page++
                            }
                        },
                        error: (e) => {
                            console.dir(e)
                        }
                    }).always(() => Vue.set(properties.$data, 'loading', false))
                }
            }
        })

        const properties = new Vue({
            el: "#properties_cards",
            mixins: [PropertyCardsMixin],
            mounted() {
                this.searchable = search.search
            }
        })

        search.search()
    } else {
      return null;
    }

}
