/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Vue = require('vue');

import firebase from 'firebase';

var config = {
    apiKey: "AIzaSyCxdVWM-njmMd5LgmRirWmZ8U73nml5Vpc",
    authDomain: "test2-b3af7.firebaseapp.com",
    databaseURL: "https://test2-b3af7.firebaseio.com",
    projectId: "test2-b3af7",
    storageBucket: "test2-b3af7.appspot.com",
    messagingSenderId: "654271186293"
};
firebase.initializeApp(config);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

const app = new Vue({
    el: '#app',

    data: {
        newUser: {email: '', password: '', name: ''},
        user: {email: '', password: ''},
        notifications: [],
        test: 'test',
        userId: 0,
        isLoading: false
    },
    created() {
        this.fetchNotifications();
        this.fetchAnnouncements();
    },

    methods: {
        register() {
            let newUser = this.newUser;
            this.isLoading = true;
            var _this = this;
            firebase.auth().createUserWithEmailAndPassword(newUser.email, newUser.password).then(function(user){
                axios.post('/sign-up', {access_token: user.user.qa, name: newUser.name}).then(function(response){
                    window.location = response.data;
                    _this.isLoading = false;
                }).catch(function(error) {
                    _this.isLoading = false;
                    alert('Something went wrong. Try again.');
                });
            }).catch(function(error) {
                _this.isLoading = false;
                alert('Something went wrong. Try again.');
            });
        },

        login() {
            let user = this.user;
            this.isLoading = true;
            var _this = this;
            firebase.auth().signInWithEmailAndPassword(user.email, user.password).then(function(user){
                axios.post('/log-in', {access_token: user.user.qa}).then(function(response){
                    _this.isLoading = false;
                    window.location = response.data;
                }).catch(function(error) {
                    _this.isLoading = false;
                    alert('Something went wrong. Try again.');
                });
            }).catch(function(error) {
                _this.isLoading = false;
                alert('Something went wrong. Try again.');
            });
        },

        fetchNotifications() {
            axios.get('/user/notifications').then(response => {
                this.notifications = response.data;
                console.log(this.notifications);
            }).catch(e => {
                console.log(e);
            });
        },

        fetchAnnouncements() {
            axios.get('/user/announcements').then(response => {
                let announcements = response.data;
                for(let i = 0; i < announcements.length; i++)
                {
                    announcementShow(announcements[i].body, announcements[i].action_url, announcements[i].action_text, announcements[i].id);
                }
            }).catch(e => {
                console.log(e);
            });
        },

        readNotifications(notification) {
            axios.put('/notifications/' + notification.id + '/read').then(response => {
                this.notifications.splice(this.notifications.indexOf(notification), 1);
            }).catch(e => {
                console.log(e);
            });
        }
    }
});
