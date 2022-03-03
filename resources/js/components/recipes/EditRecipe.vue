<template>
    <div v-if="denied" class="album bg-white mb-4 p-4">
        <div class="container p-0">
            <div class="row">
                <div class="col-md-2 text-center">
                    <p><i class="fa fa-exclamation-triangle fa-5x text-danger"></i><br/>Status Code: 403</p>
                </div>
                <div class="col-md-10">
                    <h3>OPPSSS!!!! Sorry...</h3>
                    <p>Sorry, your access is refused due to security reasons.<br/>
                        Please go back to the previous page to continue browsing.</p>
                    <router-link :to="{ name: 'home' }" class="btn btn-success">Back to safety</router-link>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <div v-if="updated" :class="(updated === true) ? 'alert alert-success alert-dismissible show' :
            'alert alert-success alert-dismissible fade'" role="alert">
            {{ updatedMessage }}
            <button type="button" class="btn-close" v-on:click="updated = !updated"></button>
        </div>
        <form @submit.prevent="updateRecipe">
            <div class="row">
                <div v-if="errors.length !== 0">
                    <validation-errors :errors="errors" :key="errorReRender" />
                </div>
                <div class="col-md-12 col-lg-8">
                    <div class="album p-4 bg-white">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" v-model="recipe.name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea rows="12" style="resize: none;" id="description" name="description" class="form-control" v-model="recipe.description"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-12 col-lg-4">
                                    <label for="type" class="form-label">Type</label>
                                    <select v-model="recipe.type" class="form-select" name="type" id="type" @change="recipeDetails">
                                        <option disabled>Select recipe type</option>
                                        <option value="sweet">Sweet</option>
                                        <option value="salty">Salty</option>
                                    </select>
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    <label for="preparation_time" class="form-label">Preparation Time</label>
                                    <select v-model="recipe.preparation_time" class="form-select" name="preparation_time" id="preparation_time" @change="recipeDetails">
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
                                    <select v-model="recipe.preparation_level" class="form-select" name="preparation_level" id="preparation_level" @change="recipeDetails">
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
                            <div class="mb-3" v-for="(ingredient, index) in recipe.ingredients">
                                <input style="display: inline-block; max-width: 90%;" class="form-control"
                                       id="ingredients" type="text" name="ingredients[]" v-model="recipe.ingredients[index]">
                                <button style="float: right" :disabled="recipe.ingredients.length === 1" class="btn btn-danger" @click="removeIngredient(index)">-</button>
                            </div>
                            <button class="btn btn-primary" @click.prevent="addIngredient">Add Ingredient</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="album p-4 bg-white">
                        <div class="mb-3">
                            <label for="newFeaturedImage" class="form-label">Featured Image</label>
                            <input class="form-control" type="file" accept="image/*" id="newFeaturedImage" name="new_featured_image" v-on:change="featuredImageChange">
                            <div class="mt-3">
                                <img id="featuredImage" width="200" :src="`/storage/images/${recipe.featured_image}`">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="new_additional_images" class="form-label">Additional Images</label>
                            <input class="form-control" type="file" multiple
                                   accept="image/*" id="new_additional_images" name="new_additional_images[]" v-on:change="additionalImagesChange">
                            <div class="mt-3 row row-cols-1 row-cols-lg-2 g-2">
                                <div class="col" style="position: relative;" v-for="(image, key) in recipe.additional_images">
                                <span @click="removeAdditional(key, 'additional')"
                                      style="position: absolute; right: -3px; top: -5px; background: #fff;
                                    border-radius: 100%; line-height: 0; " class="text-danger">
                                    <i style="font-size: 20px" class="fas fa-times-circle"></i></span>
                                    <img :src="`/storage/images/${image}`" style="object-fit: cover; width: 100%; height: 100%;" />
                                </div>
                                <div class="col" style="position: relative;" v-for="(image, key) in newImages">
                                    <span @click="removeAdditional(key, 'new')"
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
                            <button :disabled="disabled" style="vertical-align: bottom"
                                    class="btn btn-primary" type="submit">Update Recipe</button>
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
    name: "EditRecipe",
    data() {
        return {
            errorStatus: '',
            errorMsg: '',
            recipe: () => ({}),
            denied: false,
            newFeaturedImage: null,
            newImages: [],
            updated: false,
            updatedMessage: '',
            errors: [],
            errorReRender: 0,
            disabled: false,
            spinner: false
        }
    },
    mounted() {
        this.loadData();
    },
    methods: {
        loadData: function () {
            axios.get(`/api/recipes/${this.$route.params.id}`, { params: { action: 'edit'} })
            .then((response) => {
                if(response.data.recipe.User.id !== this.authUser.id) {
                    this.denied = true;
                } else {
                    this.denied = false;
                    this.recipe = response.data.recipe;
                }
            }).catch((error) => {
                this.errorStatus = error.response.statusText;
                this.errorMsg = error.response.data.message;
            })
        },
        addIngredient() {
            this.recipe.ingredients.push('');
        },
        removeIngredient(index) {
            this.recipe.ingredients.splice(index, 1);
        },
        featuredImageChange(event) {
            if(event.target.files) {
                this.newFeaturedImage = event.target.files[0];
                document.getElementById('featuredImage').src = URL.createObjectURL(event.target.files[0]);
            }
        },
        additionalImagesChange(event) {
            let selectedImages = event.target.files;

            for (let i = 0; i < selectedImages.length; i++){
                this.newImages.push(selectedImages[i]);
            }

            this.renderAdditionalImages(this.newImages);
        },
        removeAdditional(index, type) {
            if(type === 'additional') {
                this.recipe.additional_images.splice(index, 1);
            } else {
                this.newImages.splice(index, 1);
                this.renderAdditionalImages(this.newImages);
            }
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
                    this.recipe.type = event.target.value;
                    break;
                }
                case 'preparation_time': {
                    this.recipe.preparation_time = event.target.value;
                    break;
                }
                case 'preparation_level': {
                    this.recipe.preparation_level = event.target.value;
                    break;
                }
            }
        },
        updateRecipe: async function() {
            this.spinner = true;
            let formData = new FormData();
            formData.append("_method", 'PATCH');
            formData.append('name', this.recipe.name);
            formData.append('description', this.recipe.description);
            formData.append('type', this.recipe.type);
            formData.append('preparation_time', this.recipe.preparation_time);
            formData.append('preparation_level', this.recipe.preparation_level);

            if(this.newFeaturedImage !== null) {
                formData.append('new_featured_image', this.newFeaturedImage);
            }

            for(let i = 0; i < this.recipe.ingredients.length; i++) {
                formData.append('ingredients[]', this.recipe.ingredients[i])
            }

            for(let i = 0; i < this.recipe.additional_images.length; i++) {
                formData.append('additional_images[]', this.recipe.additional_images[i])
            }

            for(let i = 0; i < this.newImages.length; i++) {
                formData.append('new_additional_images[]', this.newImages[i])
            }

            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            try {
                await axios.post(`/api/recipes/${this.$route.params.id}/update`, formData, config).then((response) => {
                    if(response.status === 200) {
                        this.disabled = true;
                        this.updated = true;
                        this.updatedMessage = response.data.message;

                        setTimeout(() => {
                            this.disabled = false;
                        }, 180000)
                    }
                })
            } catch (e) {
                if (e.response.status === 422) {
                    this.errors = e.response.data.errors;
                }
            }
            finally {
                this.spinner = false;
            }
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

</style>
