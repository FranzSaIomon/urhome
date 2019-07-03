export function profile_page(FormMixin, PropertyCardsMixin, countries) {
  if ($("#vue-profile-page").length) {
    const userInfo = this
    const myInfo = this.myInfo

    return new Vue({
      el: "#vue-profile-page",
      mixins: [FormMixin, PropertyCardsMixin],
      data: {
        changed_email: false,
        userInfo,
        myInfo,
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
        chatheads: [],
        selected_chat: $.urlParam('id') ? $.urlParam('id') : null,
        messages: [],
        message: "",
        unread_count: 0,
        message_listener_created: false,
        message_page: 0,
        conversation_channel: undefined,
        top: false,
      },
      created() {
        this.page().profile(this, this.userInfo)
        this.searchable = this.load_properties

        if ($.urlParam("segment")) {
          this.changeSegment($.urlParam("segment"))
        }
      },
      watch: {
        top(top) {
          
        }
      },
      mounted() {
        let deactivate = $(this.$refs.deactivate)

        deactivate.confirmation({
          rootSelector: '[data-toggle=confirmation]',
        })

        if ($.urlParam('user')) {
          this.get_chatheads(parseInt($.urlParam('user')))
        }

        deactivate.on('confirmed.bs.confirmation', this.deactivate)

        if (this.userInfo.id == this.myInfo.id) {
          $.ajax({
            url: "/conversations/unread/count/" + this.userInfo.id,
            success: (e) => {
              this.unread_count = parseInt(e)
            }
          })

          var callback = function (data) {
            this.unread_count++;
            console.log(lel)
          }.bind(this)
  
          Echo.channel('conversation.unread.' + this.myInfo.id)
          .listen('.conversation.up', callback)
        }
      },
      updated() {
        let obj = this;
        if (this.current_segment != 'messages')
          this.message_listener_created = false;
        else if (this.current_segment === 'messages' && !this.message_listener_created && this.selected_chat) {
          this.message_listener_created = true

          $("[name=message]").on('keypress', function (e) {
            if (e.keyCode == 13 && !e.shiftKey) {
              e.preventDefault()
              obj.send()
            }
          })
        } else if (this.current_segment === 'messages') {
          $("#messages").scrollTop($("#messages").children("> .row").length <= 0 ? 0 :$("#messages").children(":last-child").offset().top)
        }
      },
      methods: {
        send(){
          if (this.selected_chat && !(this.message === null || this.message.match(/^ *$/) !== null)) {
            let securities = this.getSecurities()
            let values = {'_token': securities._token, 'content': this.message}
            
            $.ajax({
              url: '/conversations/send/' + this.selected_chat,
              method: "POST",
              data: values,
            }).always((e) => {
              console.log(e)
            })

            this.message = ""
          }
        },
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
          if (this.selected_chat && type != "messages")
            Echo.leaveChannel("conversation." + this.selected_chat)
          this.success = undefined
          this.errors = {}
          
          if (this.current_segment !== type) {
            this.current_segment = type

            if (type === 'profile') {
              this.selected_chat = null
              this.page().profile(this)
            } else if (type === 'update') {
              this.selected_chat = null
              this.page().update(this)
            } else if (type === 'messages') {
              this.chatheads = []
              this.messages = []
              this.page().messages(this)

              var callback = function (data) {
		this.get_chatheads(this.myInfo.id)
              }.bind(this)

              Echo.channel('conversation.creation.' + this.myInfo.id)
              .listen('.conversation.created', callback)
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
            messages(obj) {
              obj.get_chatheads(($.urlParam('id')) ? parseInt($.urlParam('id')) : null)
            }
          }
        },
        converse(id) {
          $.ajax({
              url: '/conversations/converse/' + id,
              method: "GET",
              success: (e) => {
                  window.location = "/users?segment=messages&id=" + id
              }
          }).always((e) => console.log(e))
        },
        get_chatheads(id) {
          $.ajax({
            url: "/conversations/chatheads",
            data: {id: id},
            success: (e) => {
              this.chatheads = e;
            }
          })

          if (this.selected_chat)
            this.loadConversation(this.selected_chat)
        },
        loadConversation(id, page) {
          this.messages = (page) ? this.messages : []
          this.message_page = (page) ? page : 0


          if (!page) {
            if (this.selected_chat)
              Echo.leaveChannel("conversation." + this.selected_chat)

            this.selected_chat = id;
            Echo.channel('conversation.' + this.selected_chat).listen('.message.posted', (data) => {
              this.messages.push(data)
              
              $.ajax({
                url: '/conversations/messages/read/' + data.id
              });

              $.ajax({
                url: "/conversations/unread/count/" + this.userInfo.id,
                success: (e) => {
                  this.unread_count = parseInt(e)
                }
              })
            })
          }

          $.ajax({
            url: '/conversations/messages/' + id,
            data: {page: this.message_page},
            success: (e) => {
              e.data.reverse()
              $.each(e.data, (i, o) => this.messages.push(o))
            }
          })
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
