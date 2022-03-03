<template>
    <div class="card shadow-sm" style="margin-bottom: 15px;">
        <span v-if="this.$route.name === 'cook-profile' && recipe.approved === 1 && action === 'cook'"
              class="badge rounded-pill bg-success" style="position: absolute; top: -10px">Approved
        </span>
        <span v-if="this.$route.name === 'cook-profile' && recipe.approved === 0 && action === 'cook'"
              class="badge rounded-pill bg-danger" style="position: absolute; top: -10px">Not Approved
        </span>
        <img v-if="details === true || action ==='cook'" class="bd-placeholder-img card-img-top" width="100%" height="225"
             :src="`/storage/images/${recipe.featured_image}`" focusable="false" :alt="`${recipe.name}`" />
        <img v-if="action === 'latest'" class="bd-placeholder-img card-img-top" width="100%" height="170"
             :src="`/storage/images/${recipe.featured_image}`" focusable="false" :alt="`${recipe.name}`" />
        <div class="card-body">
            <strong>{{ recipe.name }}</strong>
            <div v-if="action === 'top-rated'" class="rating-stars" :style="`--rating: ${recipe.average_rating}`"></div>
            <div v-if="details && action !== 'related'" class="clearfix">
                <p v-show="details" class="card-text">{{ makeExcerpt(recipe.description) }}</p>
                <div v-show="details" class="d-flex justify-content-between align-items-center">
                    <small class="text-muted"><strong><i class="fa fa-clock"></i></strong> {{ recipe.preparation_time }} min</small>
                    <small class="text-muted"><strong><i class="fa fa-chart-bar"></i></strong> {{ recipe.preparation_level }}</small>
                    <small class="text-muted"><strong><i class="fa fa-utensils"></i></strong> {{ recipe.type }}</small>
                </div>
            </div>
        </div>
        <div v-if="action !== 'cook'">
            <router-link :to="{ name: 'recipe-page', params: { id: recipe.id } }" class="stretched-link"></router-link>
        </div>
        <div v-else>
            <div class="control-overlay">
                <ul class="d-flex align-items-center justify-content-center list-unstyled icons fs-3">
                    <li class="icon mx-3">
                        <router-link v-if="recipe.approved === 1" :to="{ name: 'recipe-page', params: { id: recipe.id } }"
                                     class="text-decoration-none text-white text-decoration-none">
                            <span class="fa fa-eye"></span>
                        </router-link>
                    </li>
                    <li v-if="this.$route.name === 'cook-profile'" class="icon">
                        <router-link :to="{ name: 'edit-recipe', params: { id: recipe.id } }"
                                     class="text-decoration-none text-white text-decoration-none">
                            <span class="fas fa-edit"></span>
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Recipe",
    props: {
        recipe: {type: Object, default: () => ({})},
        action: {type: String, default: ''},
        details: {type: Boolean, default: false}
    },
    methods: {
        makeExcerpt: function (description) {
            if(description.length > 60) {
                description = `${description.slice(0, 60)}...`;
            }

            return description;
        },
    }
}
</script>

<style scoped>

</style>
