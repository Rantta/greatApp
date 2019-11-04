/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
Vue.use(Vuetify)
import { Form, HasError, AlertError } from 'vform';
import gate from './gate';
Vue.prototype.$gate = new gate(window.user);
import Swal from 'sweetalert2';
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });
window.Toast = Toast;
import moment from 'moment';
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
import VueRouter from 'vue-router';
import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
    color: '#bffaf3',
    failedColor: 'red',
    thickness: '3px',
});
Vue.use(VueRouter);

const routes = [
    {path:"/dashboard",component:require('./components/Dashboard.vue').default},
    {path:"/profile",component:require('./components/Profile.vue').default},
    {path:"/developer",component:require('./components/Developer.vue').default},
    {path:"/users",component:require('./components/Users.vue').default},
    
];
const router = new VueRouter({
    mode:'history',
    routes
});
Vue.filter('upText', function(value){
  return value.charAt(0).toUpperCase() + value.slice(1);
});
Vue.filter('myDate', function(created){
    return moment(created).format('MMMM Do YYYY');
  });
  window.Fire = new Vue();
  const VueUploadComponent = require('vue-upload-component');
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('passport-clients', require('./components/passport/Clients.vue').default);
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue').default);
Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue').default);
Vue.component('not-found', require('./components/Notfound.vue').default);
Vue.component('main-home', require('./components/Mainhome.vue').default);
Vue.component('carou-sel', require('./components/Carousel.vue').default);
Vue.component('chatt-ing', require('./components/Chat.vue').default);
Vue.component('private-chat', require('./components/PrivateChat.vue').default);
Vue.component('file-upload', VueUploadComponent);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
var navlinks = document.getElementsByClassName('navlist');
for(var i = 0; i < navlinks.length; i++){
 if(window.location.href == navlinks[i].getAttribute('href')){
   navlinks[i].classList.add('activelink');
 }
}
const app = new Vue({
    el: '#app',
    router,
    data:{
      search:"",
    },
    methods:{
      searchit: _.debounce(() => {
          Fire.$emit('searching');
      },1000)
    }
});