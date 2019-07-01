export function reactivate(FormMixin) {
    if ($("#vue-reactivate").length) {
        return new Vue({
            el: '#vue-reactivate',
            mixins: [FormMixin],
            data: {
                errors: {},
                values: {},
                success: undefined
            },
            methods: {
              reactivate() {
                let securities = this.getSecurities()
                Vue.set(this.values, Object.keys(securities)[0], Object.values(securities)[0])
                Vue.set(this.values, Object.keys(securities)[1], Object.values(securities)[1])

                this.errors = {}
                this.success = undefined
                $("#vue-reactivate button[type=submit] .spinner-border").removeAttr('hidden')
                $("#vue-reactivate button[type=submit]").attr('disabled', 'disabled')

                $.ajax({
                  url: "/users/reactivate",
                  method: "POST",
                  data: this.values,
                  success: (e) => {
                      this.success = e.message
                  }
                }).always((e) => {
                  $("#vue-reactivate button[type=submit] .spinner-border").attr('hidden', 'hidden')
                  $("#vue-reactivate button[type=submit]").removeAttr('disabled')

                  if (e.responseJSON) {
                      if (e.responseJSON.errors)
                        this.success = undefined
                    
                      $.each(e.responseJSON.errors, (key, val) => Vue.set(this.errors, key, val))
                  }
              })
              }
            }
        })
    }

    return null
}
