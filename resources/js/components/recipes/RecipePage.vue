<template>
    <div class="album mb-4">
        <div class="container p-0">
            <div v-if="errorStatus" class="alert alert-danger" role="alert">
                <h4>{{ errorStatus }}</h4>
                <p>{{ errorMsg }}</p>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-12 px-0">
                    <img :src="`/storage/images/${recipe.featured_image}`" class="img-fluid" alt="...">
                    <div class="p-4 bg-white">
                        <h3 class="mb-1">{{ recipe.name }}</h3>
                        <p>{{ recipe.description}}</p>
                    </div>
                    <div v-if="recipe.Reviews !== undefined && recipe.Reviews.length !== 0" class="mt-4 p-4 bg-white">
                        <h4>User reviews</h4>
                        <ul class="list-group">
                            <review v-for="(review, index) in recipe.Reviews" :review="review" :key="index"></review>
                        </ul>
                        <div class="mt-3" style="overflow: auto">
                            <span v-if="authUser === null" style="display: inline-block; text-align: left;">
                                <router-link class="link-primary text-decoration-none" :to="{ name: 'sign-in' }">Sign in</router-link> to leave a review.
                            </span>
                            <router-link v-if="reviewsCount > 3" :to="{ name: 'recipe-reviews' }" style="float: right"
                                class="link-primary text-decoration-none text-lg">View All Reviews
                            </router-link>
                        </div>
                    </div>
                    <div v-else class="mt-4 p-4 bg-white">
                        <h4>There are no user reviews for this recipe.</h4>
                        <span v-if="authUser === null">
                            <router-link class="link-primary text-decoration-none" :to="{ name: 'sign-in' }">Sign in</router-link> to leave a review.
                        </span>
                    </div>
                    <div v-if="authUser !== null && userReview === null" class="p-4 bg-white border-top">
                        <rating-form :recipeId="this.$route.params.id" :userId="authUser.id" @loadReviewData="refreshReviews"></rating-form>
                    </div>
                    <div v-if="authUser !== null && userReview !== null" class="p-4 bg-white border-top">
                        <edit-rating-form :recipeId="this.$route.params.id" :userReview="userReview" />
                    </div>
                    <div class="p-4 bg-white mt-4">
                        <div v-if="recipe.Comments !== undefined && recipe.Comments.length !== 0">
                            <h4>User Comments</h4>
                            <comment v-for="(comment, key) in recipe.Comments" :comment="comment" :key="key"
                            @loadCommentsData="refreshComments"></comment>
                        </div>
                        <div v-else>
                            <h4>There are no comments for this recipe.</h4>
                        </div>
                        <span v-if="authUser === null">
                            <router-link class="link-primary text-decoration-none" :to="{ name: 'sign-in' }">Sign in</router-link> to leave a comment.
                        </span>
                        <div v-if="authUser !== null">
                            <form @submit.prevent="postComment">
                                <label for="content" class="form-label fs-4">Post Comment</label>
                                <div v-if="commentError" class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <span>{{ commentErrMsg }}</span>
                                    <button type="button" class="btn-close" v-on:click.prevent="commentError = !commentError"></button>
                                </div>
                                <div class="mb-3">
                                    <textarea rows="6" style="resize: none;" id="content" name="content" class="form-control"
                                              v-model="comment"></textarea>
                                </div>
                                <div v-if="spinner" class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <button style="vertical-align: bottom" class="btn btn-primary" :disabled="disabled">Post Comment</button>
                                <div v-if="success" :class="(success === true) ? 'mt-3 alert alert-success alert-dismissible show' :
            'mt-3 alert alert-success alert-dismissible fade'" role="alert">
                                    {{ successMessage }}
                                    <button type="button" class="btn-close" v-on:click.prevent="success = !success"></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="bg-white mt-4">
                        <recipes action="related"></recipes>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div v-if="recipe.User" class="bg-white p-4">
                        <ul class="list-group-flush px-0">
                            <li class="list-group-item">
                                <div class="d-flex flex-row align-items-center">
                                    <img :src="`../storage/avatars/${recipe.User.image}`" width="80" height="80"
                                         style="display: inline-block" focusble="false" />
                                    <div style="display: inline-block; vertical-align: middle;">
                                        <strong>
                                            <router-link :to="{ name: 'cook', params: { id: recipe.User.id }}"
                                                class="text-warning text-decoration-none">{{ recipe.User.name }}</router-link>
                                        </strong><br>
                                        <strong class="mt-2">
                                            <router-link class="text-decoration-none" :to="{ name: 'cook-recipes', params: { id:recipe.User.id }}">Recipes</router-link>
                                        </strong>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item mb-0">
                                {{ recipe.User.description }}
                            </li>
                        </ul>
                    </div>
                    <div class="bg-white p-4 mt-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><strong><i class="fa fa-clock"></i></strong> {{ recipe.preparation_time }} min</small>
                            <small class="text-muted"><strong><i class="fa fa-chart-bar"></i></strong> {{ recipe.preparation_level }}</small>
                            <small class="text-muted"><strong><i class="fa fa-utensils"></i></strong> {{ recipe.type }}</small>
                        </div>
                    </div>
                    <div class="bg-white p-4 mt-4">
                        <h4>Ingridients</h4>
                        <ul class="list-group">
                            <li v-for="ingredient in recipe.ingredients" class="list-group-item">
                                {{ ingredient }}
                            </li>
                        </ul>
                    </div>
                    <div class="bg-white p-4 mt-4">
                        <h4>Additional Images</h4>
                        <div class="row row-cols-1 row-cols-lg-2 g-2">
                            <div v-for="additionalImage in recipe.additional_images" class="col">
                                <img :src="`/storage/images/${additionalImage}`"
                                     style="object-fit: cover; width: 100%; height: 100%;" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    name: "Recipe",
    data: () => {
        return {
            errorStatus: '',
            errorMsg: '',
            recipe: () => ({}),
            reviewsCount: 0,
            userReview: null,
            comment: '',
            success: false,
            successMessage: '',
            commentError: false,
            commentErrMsg: '',
            disabled: false,
            spinner: false
        }
    },
    mounted() {
        this.loadData();
    },
    methods: {
        loadData: function () {
            let self = this;
            axios.get(`/api/recipes/${this.$route.params.id}`)
                .then((response) => {
                    this.recipe = response.data.recipe;
                    this.reviewsCount = response.data.reviewsCount;
                    this.userReview = response.data.userReview;
                })
                .catch((error) => {
                    if(error.response.status === 404) {
                        self.$router.push({ name: 'not-found'});
                    }
                    this.errorStatus = error.response.statusText;
                    this.errorMsg = error.response.data.message;
                })
        },
        postComment: async function () {
            this.spinner = true;
            let formData = new FormData();
            formData.append('user_id', this.authUser.id);
            formData.append('recipe_id', this.$route.params.id);
            formData.append('content', this.comment);

            try {
                let response = await axios.post('/api/comments/post', formData);

                if(response.status === 200) {
                    this.success = true;
                    this.successMessage = response.data.message;
                    this.comment = '';
                    this.disabled = true;

                    setTimeout(() => {
                        this.disabled = false;
                    }, 180000)
                }
            }
            catch(e) {
                if (e.response.status === 422) {
                    this.commentError = true;
                    this.commentErrMsg = 'This field is required.';
                }
            }
            finally {
                this.spinner = false;
            }
        },
        refreshComments() {
            this.loadData();
        },
        refreshReviews() {
            this.loadData();
        }
    },
    computed: {
        ...mapGetters({
            authUser: 'auth/user'
        })
    }
}
</script>

<style scoped>
.card {
    position: relative;
    display: flex;
    padding: 20px;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #d2d2dc;
    border-radius: 11px;
    -webkit-box-shadow: 0px 0px 5px 0px rgb(249, 249, 250);
    -moz-box-shadow: 0px 0px 5px 0px rgba(212, 182, 212, 1);
    box-shadow: 0px 0px 5px 0px rgb(161, 163, 164)
}

.media img {
    width: 60px;
    height: 60px
}

.reply a {
    text-decoration: none
}
</style>
