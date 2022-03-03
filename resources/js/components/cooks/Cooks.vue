<template>
    <div class="album pt-4 bg-white mb-4">
        <div class="container">
            <div v-if="errorStatus" class="alert alert-danger" role="alert">
                <h4>{{ errorStatus }}</h4>
                <p>{{ errorMsg }}</p>
            </div>
            <h4>Top Cooks</h4>
            <div class="row row-cols-1">
                <div v-for="cook in cooks" class="col">
                    <div class="card shadow-sm" style="margin-bottom: 15px;">
                        <div class="d-flex flex-row">
                            <div class="p-2" style="width: 300px">
                                <img :src="`../storage/avatars/${cook.image}`" width="80" height="80"
                                     style="display: inline-block" focusble="false" />
                                <div style="display: inline-block; vertical-align: middle;">
                                    <strong><span class="text-warning">{{ cook.name }}</span></strong><br>
                                    {{ cook.city }}<br>
                                    <strong class="mt-2">{{ cook.Recipes.length }} recipes.</strong>
                                </div>
                            </div>
                            <div v-if="cook.Recipes" class="recipes-container">
                                <div style="display: inline-block; width: 100px; position: relative;" v-for="(recipe, index) in cook.Recipes.slice(0, 5)">
                                    <img width="100" height="100"
                                         :src="`../storage/images/${recipe.featured_image}`" focusable="false" />
                                    <router-link :to="{ name: 'recipe-page', params: { id: recipe.id } }" class="stretched-link"></router-link>
                                </div>
                            </div>
                            <div class="p-2 align-self-center view-cook">
                                <router-link :to="{ name: 'cook', params: { id: cook.id } }" class="link-primary text-decoration-none">
                                    <i class="fa fa-eye"></i>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="pagination !== undefined" class="clearfix">
                    <pagination :pagination="pagination" @loadPaginatedData="loadPaginatedCooks($event)"></pagination>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data: () => {
        return {
            cooks: [],
            errorStatus: '',
            errorMsg: '',
            pagination: [],
            page: 1,
        }
    },
    mounted() {
        this.loadCooks();
    },
    methods: {
        loadCooks: function() {
            axios.get('/api/cooks')
                .then((response) => {
                    this.cooks = response.data.data;
                    this.pagination = response.data.paginator;
                })
                .catch((error) => {
                    this.errorStatus = error.response.statusText;
                    this.errorMsg = error.response.data.message;
                })
        },
        loadPaginatedCooks: function(page) {
            axios.get('/api/cooks', { params: { page: page } })
                .then((response) => {
                    this.cooks = response.data.data;
                    this.pagination = response.data.paginator;
                })
                .catch((error) => {
                    this.errorStatus = error.response.statusText;
                    this.errorMsg = error.response.data.message;
                })
        }
    }
}
</script>
<style scoped>
    .recipes-container {
        overflow: hidden;
        white-space: nowrap;
    }
    .view-cook {
        margin-left: auto;
        text-align: center;
    }
    @media (max-width: 767px ) {
        .recipes-container {
            display: none;
        }
        .view-cook {
            width: 30px;
            position: absolute;
            right: 0;
        }
    }
    @media (min-width: 768px ) {
        .recipes-container {
            width: 300px;
        }
        .view-cook {
            width: 45px;
        }
    }
    @media (min-width: 991px ) {
        .recipes-container {
            width: 300px;
        }
    }
    @media (min-width: 1200px ) {
        .recipes-container {
            width: 400px;
        }
        .view-cook {
            width: 75px;
        }
    }
    @media (min-width: 1400px ) {
        .recipes-container {
            width: 500px;
        }
        .view-cook {
            width: 100px;
        }
    }
</style>
