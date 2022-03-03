/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
``
require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('app', require('./components/App').default);
Vue.component('recipes', require('./components/recipes/Recipes.vue').default);
Vue.component('recipe-page', require('./components/recipes/RecipePage.vue').default);
Vue.component('latest-comments', require('./components/comments/LastComments').default);
Vue.component('cooks', require('./components/cooks/Cooks').default);
Vue.component('home', require('./components/Home').default);
Vue.component('recipes-page', require('./components/recipes/RecipesPage').default);
Vue.component('pagination', require('./components/Pagination').default);
Vue.component('search-page', require('./components/recipes/SearchPage').default);
Vue.component('comment', require('./components/comments/Comment').default);
Vue.component('cook', require('./components/cooks/Cook').default);
Vue.component('recipe', require('./components/recipes/Recipe').default);
Vue.component('cook-recipes', require('./components/cooks/CookRecipes').default);
Vue.component('signin', require('./components/auth/SignIn').default);
Vue.component('navigation', require('./components/Navigation').default);
Vue.component('cook-details', require('./components/cooks/CookDetails').default);
Vue.component('register', require('./components/auth/Register').default);
Vue.component('edit-profile', require('./components/cooks/EditProfile').default);
Vue.component('create-recipe', require('./components/recipes/CreateRecipe').default);
Vue.component('review', require('./components/reviews/Review').default);
Vue.component('rating-form', require('./components/reviews/RatingForm').default);
Vue.component('recipe-reviews', require('./components/recipes/RecipeReviews').default);
Vue.component('validation-errors', require('./components/ValidationErrors').default);
Vue.component('forgot-password', require('./components/auth/ForgotPassword').default);
Vue.component('reset-password', require('./components/auth/ResetPasswordForm').default);
Vue.component('edit-rating-form', require('./components/reviews/RatingFormEdit').default);
Vue.component('not-found', require('./components/NotFound').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import store from "./store"
import router from "./router"

require('./store/subscriber');

window.eventBus = new Vue({});

store.dispatch('auth/attempt', localStorage.getItem('token')).then(() => {
    const app = new Vue({
        el: '#app',
        router: router,
        store
    });
});
