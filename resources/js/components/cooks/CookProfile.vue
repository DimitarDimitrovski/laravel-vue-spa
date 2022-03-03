<template>
    <div v-if="user.email_verified_at == null" class="album p-4 bg-white mb-4 text-center">
        <div v-if="errorStatus" class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ errorMsg }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div v-if="resendMessage" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ resendMessage }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <h2>Email verification required</h2>
        <h4>
            In order to access all features of your account, you must verify your email address. <br />
            Please check your email for the verification link.<br />
            No link? <a @click.prevent="resendVerification" class="link-primary text-decoration-none">Click here</a>
            to generate a new confirmation link.
        </h4>
    </div>
    <div v-else>
        <div v-if="verification" class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Email was verified successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="album p-4 bg-white mb-4">
            <div class="container">
                <div v-if="errorStatus" class="alert alert-danger" role="alert">
                    <h4>{{ errorStatus }}</h4>
                    <p>{{ errorMsg }}</p>
                </div>
                <div class="row">
                    <span style="width: auto; font-size: 15px;" class="badge bg-warning ms-3 mb-3">
                        <router-link :to="{ name: 'edit-profile' }" class="text-decoration-none text-white">
                            <i class="fa fa-edit"></i> Edit Details
                        </router-link>
                    </span>
                    <cook-details :user="user" :recipesCount="recipesCount" />
                </div>
            </div>
        </div>
        <div class="album p-4 bg-white mb-4">
            <div v-if="recipes">
                <h4 class="border-bottom pb-3 mb-4">Your recipes <span style="float: right; margin-top: -5px"
                    class="badge bg-success">
                    <router-link class="text-white text-decoration-none" :to="{ name: 'create-recipe' }">
                        <i class="fa fa-plus"></i> Add recipe
                    </router-link></span></h4>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <div v-for="recipe in recipes" class="col">
                        <recipe :recipe="recipe" action="cook" :details="false"></recipe>
                    </div>
                </div>
                <div v-if="pagination !== undefined" class="clearfix">
                    <pagination :pagination="pagination" @loadPaginatedData="loadPaginatedRecipes($event)"></pagination>
                </div>
            </div>
            <div v-else>
                <h4>You have not published any recipes yet.</h4>
            </div>
        </div>
        <div v-if="topRated" class="album p-4 bg-white mb-4">
            <h4>Your top rated recipes</h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <div v-for="recipe in topRated" class="col">
                    <recipe :recipe="recipe" action="top-rated" :details="true"></recipe>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    name: "CookProfile",
    data() {
        return {
            topRated: [],
            recipes: [],
            recipesCount: 0,
            errorStatus: '',
            errorMsg: '',
            verification: false,
            resendMessage: '',
            pagination: [],
            page: 1
        }
    },
    mounted() {
        this.loadData();
        const queryString = window.location.search;

        if(queryString) {
            const urlParams = new URLSearchParams(queryString);
            const verified = urlParams.get('verified');

            if(verified) {
                this.verification = true;
            }
        }
    },
    methods: {
        loadData: function() {
            axios.get(`/api/cooks/${this.user.id}/profile`, { params: { action: 'cook-profle' } })
                .then((response) => {
                    this.topRated = response.data.topRated;
                    this.recipes = response.data.recipes;
                    this.pagination = response.data.paginator;
                    this.recipesCount = response.data.recipesCount;
                })
                .catch((error) => {
                    this.errorStatus = error.response.statusText;
                    this.errorMsg = error.response.data.message;
                })
        },
        resendVerification: function () {
            axios.post('/api/email/resend', { id: this.user.id})
            .then((response) => {
                this.resendMessage = response.data;
            })
            .catch((error) => {
                this.errorStatus = error.response.statusText;
                this.errorMsg = error.response.data;
            })
        },
        loadPaginatedRecipes: function(page) {
            axios.get(`/api/cooks/${this.user.id}/profile`, {params: {page: page}})
                .then((response) => {
                    this.recipes = response.data.recipes;
                    this.pagination = response.data.paginator;
                })
                .catch((error) => {
                    this.errorStatus = error.response.statusText;
                    this.errorMsg = error.response.data.message;
                })
        }
    },
    computed: {
        ...mapGetters({
            user: 'auth/user'
        })
    }
}
</script>

<style scoped>

</style>
