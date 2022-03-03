<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <router-link :to="{ name: 'home'}"><img height="70" :src="`/storage/images/logo.svg`"></router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link :to="{ name: 'recipes-page' }" class="nav-link">Recipes</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'cooks' }" class="nav-link">Cooks</router-link>
                    </li>
                </ul>
                <div class="d-flex">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search" v-model="search">
                        <div :class="search.length === 0 ? 'input-group-append disabled' : 'input-group-append'">
                            <router-link :to="{ name: 'search-page', params: { keyword: search } }"
                                style="border-radius: 0 0.25rem 0.25rem 0" class="btn btn-outline-light">
                                <i class="fa fa-search"></i>
                            </router-link>
                        </div>
                    </div>
                </div>
                <ul style="margin-left: auto; margin-right: unset !important;" class="navbar-nav me-auto mb-2 mb-lg-0">
                    <template v-if="authenticated === null">
                        <li class="nav-item">
                            <router-link :to="{ name: 'register' }" class="nav-link">Register</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'sign-in' }" class="nav-link">Sign in</router-link>
                        </li>
                    </template>
                    <template v-else>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <img :src="`/storage/avatars/${user.image}`" width="30" height="30"
                                class="rounded-circle" /> {{ user.name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <router-link :to="{ name: 'cook-profile', params:{ id: user.id }}" class="dropdown-item">
                                        Account
                                    </router-link>
                                </li>
                                <li>
                                    <router-link :to="{ name: 'forgot-password' }" class="dropdown-item">
                                        Reset Password
                                    </router-link>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" @click.prevent="signOut">Sign out</a></li>
                            </ul>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    name: "Navigation",
    data() {
        return {
            search: '',
            disabled: true
        }
    },
    methods: {
        ...mapActions({
            signOutAction: 'auth/signOut'
        }),

        signOut() {
            this.signOutAction().then(() => {
                this.$router.replace({
                    name: 'home'
                })
            })
        }
    },
    computed: {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user'
        })
    }
}
</script>

<style scoped>
    .disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }
    .disabled a {
        pointer-events: none;
    }
    .disabled:hover {
        cursor: not-allowed;
    }
</style>
