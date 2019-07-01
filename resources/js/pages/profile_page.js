import { delay } from "q";

export function profile_page(FormMixin, PropertyCardsMixin, countries) {
  if ($("#vue-profile-page").length) {
    const userInfo = this

    return new Vue({
      el: "#vue-profile-page",
      mixins: [FormMixin, PropertyCardsMixin],
      data: {
        changed_email: false,
        userInfo,
        success: undefined,
        current_page: 1,
        current_segment: "profile",
        countries,
        errors: {},
        values: {
          c_email: {},
          c_profile: {},
          c_password: {},
        },
        password: "",
      },
      created() {
        this.page().profile(this, this.userInfo)
        this.searchable = this.load_properties

        if ($.urlParam("segment")) {
          this.changeSegment($.urlParam("segment"))
        }
      },
      mounted() {
        let deactivate = $(this.$refs.deactivate)

        deactivate.confirmation({
          rootSelector: '[data-toggle=confirmation]',
        })

        deactivate.on('confirmed.bs.confirmation', this.deactivate)
      },
      methods: {
        deactivate() {
          let alertDiv = $("<div class='alert'></div>")
          let dismiss = $("<button type='button' class='close' data-dismiss='modal'>&times;</button>")
          alertDiv.append(dismiss)
          $("#modalAlert").html(alertDiv)

          $.ajax({
            url: "/users/destroy/" + this.userInfo.id,
            success: (e) => {
              alertDiv.html("<b>Success: </b> Your account has been deactivated. Please wait to be redirected.")
              alertDiv.addClass("alert-success");

              setTimeout(() => location.reload(), 800);
            },
            error: (e) => {
              alertDiv.html("<b>Error: </b> Something went wrong while deactivating your account. Please try again later.")
              alertDiv.addClass("alert-danger");
            }
          }).always((e) => {
            $("#modalAlert").parent(".modal").modal('show')
          })
        },
        changeSegment(type) {
          this.success = undefined
          this.errors = {}
          if (this.current_segment !== type) {
            this.current_segment = type

            if (type === 'profile') {
              this.page().profile(this)
            } else if (type === 'update') {
              this.page().update(this)
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
              let user_copy = Object.assign({}, obj.userInfo)
              Vue.set(obj.values, "c_email", {email: obj.userInfo.email})
              Vue.set(obj.values, "c_profile", user_copy)
            },
            change_password() {

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
        },
        c_update() {
          this.success = undefined
          this.errors = {}
          let securities = this.getSecurities()
          Vue.set(this.values.c_profile, Object.keys(securities)[0], Object.values(securities)[0])
          Vue.set(this.values.c_profile, Object.keys(securities)[1], Object.values(securities)[1])
          Vue.set(this.values.c_profile, "password", this.values.password)
          
          $("#update_profile_btns button .spinner-border").removeAttr('hidden')
          $("#update_profile_btns input, #update_profile_btns button").attr("disabled", "disabled")
          $.ajax({
            url: "/users/update/" + this.userInfo.id,
            method: "POST",
            data: this.values.c_profile,
            success: (e) => {
              this.success = e.success;
              let new_info = Object.assign({}, this.values.c_profile)

              Vue.set(this, 'userInfo', new_info)
            },
            error: (e) => {
              $.each(e.responseJSON.errors, (key, val) => Vue.set(this.errors, key, val))
              this.success = undefined
            }
          }).always((e) => {
            $("#update_profile_btns button .spinner-border").attr('hidden', 'hidden')
            $("#update_profile_btns input, #update_profile_btns button").removeAttr("disabled")

            this.values.password = "";
          })
        },
        c_email() {
          this.success = undefined
          this.errors = {}
          let securities = this.getSecurities()
          Vue.set(this.values.c_email, Object.keys(securities)[0], Object.values(securities)[0])
          Vue.set(this.values.c_email, Object.keys(securities)[1], Object.values(securities)[1])
          Vue.set(this.values.c_email, "password", this.values.password)

          $("#update_email_btns button .spinner-border").removeAttr('hidden')
          $("#update_email_btns input, #update_email_btns button").attr("disabled", "disabled")
          $.ajax({
            url: "/users/update/email/" + this.userInfo.id,
            method: "POST",
            data: this.values.c_email,
            success: (e) => {
              this.success = e.success
              this.changed_email = true
              Vue.set(this.userInfo, 'email', this.c_email.email)
            },
            error: (e) => {
              $.each(e.responseJSON.errors, (key, val) => Vue.set(this.errors, key, val))
              this.success = undefined
            }
          }).always((e) => {
            $("#update_email_btns button .spinner-border").attr('hidden', 'hidden')
            $("#update_email_btns input, #update_email_btns button").removeAttr("disabled")

            this.values.password = "";
          })
        },
        c_password() {
          this.success = undefined
          this.errors = {}
          let securities = this.getSecurities()
          Vue.set(this.values.c_password, Object.keys(securities)[0], Object.values(securities)[0])
          Vue.set(this.values.c_password, Object.keys(securities)[1], Object.values(securities)[1])

          $("#update_password_btns button .spinner-border").removeAttr('hidden')
          $("#update_password_btns input, #update_password_btns button").attr("disabled", "disabled")
          $.ajax({
            url: "/users/update/password/" + this.userInfo.id,
            method: "POST",
            data: this.values.c_password,
            success: (e) => {
              this.success = e.success
            },
            error: (e) => {
              $.each(e.responseJSON.errors, (key, val) => Vue.set(this.errors, key, val))
              this.success = undefined
            }
          }).always((e) => {
            $("#update_password_btns button .spinner-border").attr('hidden', 'hidden')
            $("#update_password_btns input, #update_password_btns button").removeAttr("disabled")

            this.values.c_password = {};
          })
        },
        resend_verification() {
          let securities = this.getSecurities()
          $("#update_email_btns button .spinner-border").removeAttr('hidden')
          $("#update_email_btns input, #update_email_btns button").attr("disabled", "disabled")
          
          let data = {
            _token: Object.values(securities)[0]
          }

          $.ajax({
            url: "/users/email/resend/" + this.userInfo.id,
            data,
            method: "POST",
            success: (e) => {
              this.success = e.success
            }
          }).always((e) => {
            $("#update_email_btns button .spinner-border").attr('hidden', 'hidden')
            $("#update_email_btns input, #update_email_btns button").removeAttr("disabled")
          })
        },
        reset_email() {
          Vue.set(this.values.c_email, "email", this.userInfo.email)
        },
        reset_profile() {
          let user_copy = Object.assign({}, this.userInfo)
          Vue.set(this.values, "c_profile", user_copy)
        }
      }
    })
  } else {
    return null
  }
}