jQuery(document).ready(function($) {

  new Vue({
    delimiters: ['${', '}'],
    el: '#regiter',
    data: {
      email: {
        value: '',
      },
      password: {
        value: ''
      },
      password_confirm: {
        value: ''
      },
      role: {
        value: ''
      },
      activation_compte: {
        value: ''
      },
      /**
		 * Ajax
		 */
      url_post: '/index.php',
      headers: '',
      post_datas: '',
      trigger_post_loanding: 0,
    },
    methods: {
      register() {
          console.log('Register user');
          var fields = {
            email: this.email.value,
            password: this.password.value,
            password_confirm: this.password_confirm.value,
            role: this.role.value,
            activation_compte: this.activation_compte.value,
          };
          this.post_datas = {
            fields: fields,
            databaseConfig: 'Nutribe-Auth',
          };
          this.headers = {
            'Content-Type': 'application/json',
            'X-CSRF-Token': 'registeruser',
            'Accept': 'application/json',
          };
          this.trigger_post_loanding++;
        },
        data_from_ajax(datas) {
          console.log(' datas ', datas);
        }
    }
  });
});
