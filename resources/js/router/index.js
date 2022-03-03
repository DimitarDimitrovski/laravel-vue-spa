import Vue from "vue";
import VueRouter from 'vue-router';
import Cooks from "../components/cooks/Cooks";
import Home from "../components/Home";
import RecipesPage from "../components/recipes/RecipesPage";
import RecipePage from "../components/recipes/RecipePage";
import SearchPage from "../components/recipes/SearchPage";
import Cook from "../components/cooks/Cook";
import CookRecipes from "../components/cooks/CookRecipes";
import SignIn from "../components/auth/SignIn";
import CookProfile from "../components/cooks/CookProfile";
import store from '../store'
import Register from "../components/auth/Register";
import EditProfile from "../components/cooks/EditProfile";
import CreateRecipe from "../components/recipes/CreateRecipe";
import EditRecipe from "../components/recipes/EditRecipe";
import RecipeReviews from "../components/recipes/RecipeReviews";
import ForgotPassword from "../components/auth/ForgotPassword";
import ResetPasswordForm from "../components/auth/ResetPasswordForm";
import NotFound from "../components/NotFound";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },
        {
            path: '/sign-in',
            name: 'sign-in',
            component: SignIn
        },
        {
            path: '/register-user',
            name: 'register',
            component: Register
        },
        {
            path: '/reset-password',
            name: 'forgot-password',
            component: ForgotPassword
        },
        {
            path: '/reset-password/:token',
            name: 'reset-password-form',
            component: ResetPasswordForm,
        },
        {
            path: '/cooks',
            name: 'cooks',
            component: Cooks,
        },
        {
            path: '/cooks/:id',
            name: 'cook',
            component: Cook
        },
        {
            path: '/edit-profile',
            name: 'edit-profile',
            component: EditProfile,
            beforeResolve: (to, from, next) => {
                if(!store.getters["auth/authenticated"]) {
                    return next({ name: 'sign-in' })
                }
                if(store.getters["auth/user"].email_verified_at === null) {
                    return next({ name: 'cook-profile'})
                }
                next()
            }
        },
        {
            path: '/cook-profile',
            name: 'cook-profile',
            component: CookProfile,
            beforeRouteUpdate: (to, from, next) => {
                if(!store.getters["auth/authenticated"]) {
                    return next({ name: 'sign-in' })
                }
                next()
            }
        },
        {
            path: '/cooks/:id/recipes',
            name: 'cook-recipes',
            component: CookRecipes
        },
        {
            path: '/recipes',
            name: 'recipes-page',
            component: RecipesPage
        },
        {
            path: '/recipes/:id',
            name: 'recipe-page',
            component: RecipePage
        },
        {
            path: '/recipes/:id/reviews',
            name: 'recipe-reviews',
            component: RecipeReviews
        },
        {
            path: '/recipes/:id/edit',
            name: 'edit-recipe',
            component: EditRecipe,
            beforeResolve: (to, from, next) => {
                if(!store.getters["auth/authenticated"]) {
                    return next({ name: 'sign-in' })
                }

                if(store.getters["auth/user"].email_verified_at === null) {
                    return next({ name: 'cook-profile'})
                }
                next()
            }
        },
        {
            path: '/create-recipe',
            name: 'create-recipe',
            component: CreateRecipe,
            beforeResolve: (to, from, next) => {
                if(!store.getters["auth/authenticated"]) {
                    return next({ name: 'sign-in' })
                }

                if(store.getters["auth/user"].email_verified_at === null) {
                    return next({ name: 'cook-profile'})
                }
                next()
            }
        },
        {
            path: '/search/:keyword',
            name: 'search-page',
            component: SearchPage
        },
        {
            path: '*',
            name: 'not-found',
            component: NotFound
        },
    ],
});

export default router;
