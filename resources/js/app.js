/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



require('./bootstrap');

window.Vue = require('vue');
const swal = window.swal = require('sweetalert2');



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login', require('./components/Login.vue').default);
Vue.component('index', require('./components/index.vue').default);

// users
Vue.component('accounts', require('./components/User/Accounts.vue').default);
Vue.component('account', require('./components/User/Account.vue').default);
Vue.component('newAccount', require('./components/User/NewAccount.vue').default);

// roles
Vue.component('role', require('./components/Role/Role.vue').default);
Vue.component('roles', require('./components/Role/Roles.vue').default);
Vue.component('newRole', require('./components/Role/NewRole.vue').default);

// Expense
Vue.component('expense', require('./components/Expense/Expense.vue').default);
Vue.component('expenses', require('./components/Expense/Expenses.vue').default);
Vue.component('newExpense', require('./components/Expense/NewExpense.vue').default);

// User Expenses
Vue.component('user-expense', require('./components/UserExpense/Expense.vue').default);
Vue.component('user-expenses', require('./components/UserExpense/Expenses.vue').default);
Vue.component('user-newExpense', require('./components/UserExpense/NewExpense.vue').default);

// Chart
Vue.component('chart', require('./components/Chart.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    
});
