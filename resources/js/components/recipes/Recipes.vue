<template>
    <div class="album py-4 bg-white mb-4">
        <div class="container">
            <div v-if="errorStatus" class="alert alert-danger" role="alert">
                <h4>{{ errorStatus }}</h4>
                <p>{{ errorMsg }}</p>
            </div>
            <div v-if="recipes !== undefined" class="clearfix">
                <h4>{{ generateTitle }}</h4>
            </div>
            <div v-if="recipes.length === 0" class="clearfix">
                <h4>No records found.</h4>
            </div>
            <div :class="classes">
                <div v-for="recipe in recipes" class="col">
                    <recipe :recipe=recipe :action="action" :details="showDetails"></recipe>
                </div>
            </div>
            <div v-if="pagination !== undefined && (action === 'all' || 'search') && recipes.length > 0" class="clearfix">
                <pagination :pagination="pagination" @loadPaginatedData="loadPaginatedProducts($event)"></pagination>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['action'],
        data: () => {
            return {
                recipesKey: 0,
                recipes: [],
                errorStatus: '',
                errorMsg: '',
                classes: 'row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3',
                showDetails: true,
                pagination: [],
                page: 1,
                endpoint: '/api/recipes',
            }
        },
        mounted() {
            this.loadProducts();

            if(this.action === 'latest') {
                this.classes = 'row row-cols-1';
                this.showDetails = false;
            }
        },
        methods: {
            loadProducts: function() {
                let params = {
                    action: this.action
                }
                if(this.action === 'search') {
                    params = {
                        action: this.action,
                        keyword: this.$route.params.keyword
                    }
                }
                if(this.action === 'related') {
                    params = {
                        action: this.action,
                        id: this.$route.params.id
                    }
                }
                axios.get(this.endpoint, { params: params })
                .then((response) => {
                    this.recipes = response.data.data;

                    if(this.action === 'all' || 'search') {
                        this.pagination = response.data.paginator;
                    }
                })
                .catch((error) => {
                    this.errorStatus = error.response.statusText;
                    this.errorMsg = error.response.data.message;
                })
            },
            loadPaginatedProducts: function(page) {
                axios.get(this.endpoint, { params: { action: this.action, page: page } })
                .then((response) => {
                    this.recipes = response.data.data;
                    this.pagination = response.data.paginator;
                })
                .catch((error) => {
                    this.errorStatus = error.response.statusText;
                    this.errorMsg = error.response.data.message;
                })
            },
        },
        computed: {
            generateTitle: function () {
                let word = ' Recipes';

                if(this.action === 'search') {
                    word = ' Results';
                }

                return this.action.replace(/^./, this.action[0].toUpperCase()) + word;
            }
        }
    }
</script>
<style>

</style>
