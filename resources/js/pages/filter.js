export function filter(FormMixin) {
  if ($("#vue-filter").length) {
    return new Vue({
        el: "#vue-filter",
        mixins: [FormMixin],
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
        }, 
        data: {
            options: [],
            toggles: [
                {
                    name: 'For Rent',
                    value: 1
                },{
                    name: 'For Sale',
                    value: 2
                }
            ],
            values: {},
            errors: {},
        },
        methods: {
            search(e) {
                if ($("#vue-filter").is('[local]')) {
                } else {
                    $("#vue-filter").submit()
                }
            }
        }
    });
  } else {
    return null;
  }
}