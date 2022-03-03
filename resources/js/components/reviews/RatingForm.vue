<template>
    <div>
        <div v-if="errors.length !== 0">
            <validation-errors :errors="errors" :key="errorReRender" />
        </div>
        <h4>Rate Recipe</h4>
        <div v-if="success" class="alert alert-success alert-dismissible show" role="alert">
            {{ successMessage }}
            <button type="button" class="btn-close" v-on:click.prevent="success = !success"></button>
        </div>
        <form @submit.prevent="submitRating">
            <div class="mb-3">
                <label class="form-label" for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" v-model="title">
            </div>
            <div class="mb-3">
                <label class="form-label" for="description">Description</label>
                <textarea rows="6" style="resize: none;" id="description" name="description" class="form-control"
                          v-model="description"></textarea>
            </div>
            <div class="rating-wrapper">
                <!-- star 5 -->
                <input type="radio" v-on:change="setRating" id="5-star-rating" name="star-rating" value="5">
                <label for="5-star-rating" class="star-rating">
                    <i class="fas fa-star d-inline-block"></i>
                </label>
                <!-- star 4 -->
                <input type="radio" v-on:change="setRating" id="4-star-rating" name="star-rating" value="4">
                <label for="4-star-rating" class="star-rating star">
                    <i class="fas fa-star d-inline-block"></i>
                </label>
                <!-- star 3 -->
                <input type="radio" v-on:change="setRating" id="3-star-rating" name="star-rating" value="3">
                <label for="3-star-rating" class="star-rating star">
                    <i class="fas fa-star d-inline-block"></i>
                </label>
                <!-- star 2 -->
                <input type="radio" v-on:change="setRating" id="2-star-rating" name="star-rating" value="2">
                <label for="2-star-rating" class="star-rating star">
                    <i class="fas fa-star d-inline-block"></i>
                </label>
                <!-- star 1 -->
                <input type="radio" v-on:change="setRating" id="1-star-rating" name="star-rating" value="1">
                <label for="1-star-rating" class="star-rating star">
                    <i class="fas fa-star d-inline-block"></i>
                </label>
            </div>
            <div v-if="spinner" class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <button style="float: right; margin-top: 5px; vertical-align: bottom" class="btn btn-primary" :disabled="disabled">RATE</button>
        </form>
    </div>
</template>

<script>
export default {
    name: "RatingForm",
    props: ['recipeId', 'userId'],
    data() {
        return {
            reviews: [],
            title: '',
            description: '',
            rating: 0,
            errorReRender: 0,
            errors: [],
            success: false,
            successMessage: '',
            disabled: false,
            spinner: false
        }
    },
    methods: {
        submitRating: async function () {
            this.spinner = true;
            let formData = new FormData();
            formData.append('recipe_id', this.recipeId);
            formData.append('user_id', this.userId);
            formData.append('title', this.title);
            formData.append('description', this.description);
            formData.append('rating', this.rating);

            try {
                let response = await axios.post('/api/reviews/create', formData);
                this.success = true;
                this.successMessage = response.data.message;
                this.disabled = true;

                setTimeout(() => {
                    this.disabled = false;
                }, 180000)

            } catch (e) {
                if (e.response.status === 422) {
                    this.errors = e.response.data.errors;
                    this.errorReRender += 1;
                }
            }
            finally {
                this.spinner = false;
            }
        },
        setRating(event) {
            this.rating = event.target.value;
        }
    }
}
</script>

<style scoped>
    .rating-wrapper {
        align-self: center;
        display: inline-flex;
        direction: rtl !important;
        margin-left: auto;
    }
    .rating-wrapper label {
        color: #E1E6F6;
        cursor: pointer;
        display: inline-flex;
        font-size: 3rem;
        padding: 0 .6rem;
        transition: color 0.5s;
    }
    svg {
        -webkit-text-fill-color: transparent;
        filter:drop-shadow(5px 1px 3px rgba(198, 206, 237, 1));
        -webkit-filter: drop-shadow (4px 1px 6px rgba(198, 206, 237, 1));
    }
    .rating-wrapper input {
        height: 100%;
        width: 100%;
    }
    .rating-wrapper input {
        display: none;
    }
    .rating-wrapper label:hover,
    .rating-wrapper label:hover ~ label,
    .rating-wrapper input:checked ~ label  {
        color: #ffcc00;
    }
    .rating-wrapper label:hover,
    .rating-wrapper label:hover ~ label,
    .rating-wrapper input:checked ~ label  {
        color: #ffcc00;
    }
</style>
