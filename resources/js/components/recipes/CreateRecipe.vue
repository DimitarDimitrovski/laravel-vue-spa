<template>
    <div>
        <div v-if="modal" id="success-modal" style="display: block; background-color: rgb(0 0 0 / 25%);" role="dialog"
             class="modal fade show" aria-modal="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Success!</h3>
                    </div>
                    <div class="modal-body">
                        <h5>{{ modalMessage }}</h5>
                    </div>
                    <div class="modal-footer">
                        <router-link :to="{ name: 'cook-profile' }" type="button" class="btn btn-primary">OK</router-link>
                    </div>
                </div>
            </div>
        </div>
        <form @submit.prevent="createRecipe">
            <div class="row">
                <div v-if="errors.length !== 0">
                    <validation-errors :errors="errors" :key="errorReRender" />
                </div>
                <div class="col-md-12 col-lg-8">
                    <div class="album p-4 bg-white">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" v-model="form.name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea rows="12" style="resize: none;" id="description" name="description" class="form-control" v-model="form.description"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-12 col-lg-4">
                                    <label for="type" class="form-label">Type</label>
                                    <select class="form-select" name="type" id="type" @change="recipeDetails">
                                        <option selected disabled>Select recipe type</option>
                                        <option value="sweet">Sweet</option>
                                        <option value="salty">Salty</option>
                                    </select>
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    <label for="preparation_time" class="form-label">Preparation Time</label>
                                    <select class="form-select" name="preparation_time" id="preparation_time" @change="recipeDetails">
                                        <option selected disabled>Select preparation time</option>
                                        <option value="30">30 min.</option>
                                        <option value="30-60">30-60 min.</option>
                                        <option value="60-120">60-120 min.</option>
                                        <option value="120-180">120-180 min.</option>
                                        <option value="180">Over 180 min.</option>
                                    </select>
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    <label for="preparation_level" class="form-label">Preparation Level</label>
                                    <select class="form-select" name="preparation_level" id="preparation_level" @change="recipeDetails">
                                        <option selected disabled>Select preparation level</option>
                                        <option value="easy">Easy</option>
                                        <option value="medium">Medium</option>
                                        <option value="hard">Hard</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="ingredients" class="form-label">Ingredients</label>
                            <div class="mb-3" v-for="(ingredient, index) in form.ingredients">
                                <input style="display: inline-block; max-width: 90%;" class="form-control"
                                       id="ingredients" type="text" name="ingredients[]" v-model="ingredient.value">
                                <button style="float: right" :disabled="form.ingredients.length === 1" class="btn btn-danger" @click="removeIngredient(index)">-</button>
                            </div>
                            <button class="btn btn-primary" @click.prevent="addIngredient">Add Ingredient</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="album p-4 bg-white">
                        <div class="mb-3">
                            <label for="featured_image" class="form-label">Featured Image</label>
                            <input class="form-control" type="file" accept="image/*" id="featured_image" name="featured_image" v-on:change="featuredImageChange">
                            <div class="mt-3">
                                <img id="featuredImage" width="200" src="">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="additional_images" class="form-label">Additional Images</label>
                            <input class="form-control" type="file" multiple
                                   accept="image/*" id="additional_images" name="additional_images[]" v-on:change="additionalImagesChange">
                            <div class="mt-3 row row-cols-1 row-cols-lg-2 g-2">
                                <div class="col" style="position: relative;" v-for="(image, key) in form.additional_images">
                                <span @click="removeAdditional(key)"
                                      style="position: absolute; right: -3px; top: -5px; background: #fff;
                                    border-radius: 100%; line-height: 0; " class="text-danger">
                                    <i style="font-size: 20px" class="fas fa-times-circle"></i></span>
                                    <img v-bind:ref="'image' +parseInt( key )" style="object-fit: cover; width: 100%; height: 100%;" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-3" style="text-align: right;">
                            <div v-if="spinner" class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <button style="vertical-align: bottom"
                                    class="btn btn-primary" type="submit"><i class="fa fa-plus"></i> Create Recipe</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    name: "CreateRecipe",
    data() {
        return {
            form: {
                user_id: null,
                name: '',
                description: '',
                ingredients: [
                    { value: '' }
                ],
                type: '',
                preparation_time: '',
                preparation_level: '',
                featured_image: null,
                additional_images: [],
            },
            errors: [],
            errorReRender: 0,
            modal: false,
            modalMessage: '',
            spinner: false
        }
    },
    mounted() {
        this.form.user_id = this.user.id;
    },
    methods: {
        addIngredient() {
            this.form.ingredients.push( { value: '' });
        },
        removeIngredient(index) {
            this.form.ingredients.splice(index, 1);
        },
        featuredImageChange(event) {
            if(event.target.files) {
                this.form.featured_image = event.target.files[0];
                document.getElementById('featuredImage').src = URL.createObjectURL(event.target.files[0]);
            }
        },
        additionalImagesChange(event) {
            let selectedImages = event.target.files;

            for (let i = 0; i < selectedImages.length; i++){
                this.form.additional_images.push(selectedImages[i]);
            }

            this.renderAdditionalImages(this.form.additional_images);
        },
        removeAdditional(index) {
            this.form.additional_images.splice(index, 1);
            this.renderAdditionalImages(this.form.additional_images);
        },
        renderAdditionalImages(additionalImages) {
            for (let i = 0; i < additionalImages.length; i++) {
                let reader = new FileReader(); //instantiate a new file reader
                reader.addEventListener('load', function(){
                    this.$refs['image' + parseInt( i )][0].src = reader.result;
                }.bind(this), false);  //add event listener

                reader.readAsDataURL(additionalImages[i]);
            }
        },
        recipeDetails(event) {
            switch (event.target.id) {
                case 'type': {
                    this.form.type = event.target.value;
                    break;
                }
                case 'preparation_time': {
                    this.form.preparation_time = event.target.value;
                    break;
                }
                case 'preparation_level': {
                    this.form.preparation_level = event.target.value;
                    break;
                }
            }
        },
        createRecipe: async function() {
            this.spinner = true;
            let formData = new FormData();
            formData.append('user_id', this.form.user_id);
            formData.append('name', this.form.name);
            formData.append('description', this.form.description);
            formData.append('type', this.form.type);
            formData.append('preparation_time', this.form.preparation_time);
            formData.append('preparation_level', this.form.preparation_level);

            if(this.form.featured_image !== null) {
                formData.append('featured_image', this.form.featured_image);
            }

            for(let i = 0; i < this.form.ingredients.length; i++) {
                formData.append('ingredients[]', this.form.ingredients[i].value)
            }

            for(let i = 0; i < this.form.additional_images.length; i++) {
                formData.append('additional_images[]', this.form.additional_images[i])
            }

            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            try {
                let response = await axios.post('/api/recipes/store', formData, config);

                if(response.status === 200) {
                    this.modal = true;
                    this.modalMessage = response.data.message;
                }
            } catch (e) {
                if (e.response.status === 422) {
                    this.errors = e.response.data.errors;
                    this.errorReRender += 1;
                }
            } finally {
                this.spinner = false;
            }
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
