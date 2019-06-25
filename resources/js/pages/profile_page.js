export function profile_page(FormMixin, PropertyCardsMixin, countries) {
  if ($("#vue-profile-page").length) {
    const userInfo = this

    return new Vue({
      el: "#vue-profile-page",
      mixins: [FormMixin, PropertyCardsMixin],
      data: {
        userInfo,
        current_page: 1,
        current_segment: "profile",
      },
      created() {
        this.page().profile(this, this.userInfo)
        this.searchable = this.load_properties
      },
      methods: {
        changeSegment(type) {
          if (this.current_segment !== type) {
            this.current_segment = type

            if (type === 'profile') {
              this.page().profile(this)
            } else if (type === 'update') {
              this.page().update()
            }
          }
        },
        page() {
          return {
            profile(obj) {
              if (obj.userInfo.UserType) {
                obj.load_properties(true)
              }
            },
            update(obj) {
              
            },
            c_password() {

            },
            c_email() {
              
            }
          }
        },
        load_properties(clear) {
          if (this.userInfo.id) {
            if (clear) {
              this.current_page = 1
              Vue.set(this.$data, 'cards', [])
            }
            this.loading = true

            $.ajax({
              url: "/api/property/paginate",
              data: {
                page: this.current_page,
                UserID: this.userInfo.id
              },
              success: (e) => {
                if (e.data && e.data.length) {
                  Vue.set(this.$data, 'resultCount', e.total)
  
                  $.each(e.data, (i, o) => this.cards.push(o))
                  this.current_page++
                }
              }
            }).always((e) => {
              this.loading = false
            })
          }
        }
      }
    })
  } else {
    return null
  }
}