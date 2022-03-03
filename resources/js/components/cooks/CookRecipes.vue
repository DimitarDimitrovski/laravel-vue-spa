<template>
    <div class="album py-4 bg-white mb-4">
        <div class="container">
            <div v-if="errorStatus" class="alert alert-danger" role="alert">
                <h4>{{ errorStatus }}</h4>
                <p>{{ errorMsg }}</p>
            </div>
            <div v-if="recipes !== undefined" class="clearfix">
                <h4>{{ headline }}</h4>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <div v-for="recipe in recipes" class="col">
                    <recipe :recipe=recipe :action="action" :details="true"></recipe>
                </div>
            </div>
            <div v-if="pagination !== undefined && (action === 'all' || 'search')" class="clearfix">
                <pagination :pagination="pagination" @loadPaginatedData="loadPaginatedProducts($event)"></pagination>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CookRecipes",
    data: () => {
        return  {
            recipes: [],
            errorStatus: '',
            errorMsg: '',
            pagination: [],
            page: 1,
            username: '',
            action: 'all'
        }
    },
    mounted() {
        this.loadData();
    },
    methods: {
        loadData: function () {
            axios.get(`/api/cooks/${this.$route.params.id}/recipes`)
                .then((response) => {
                    this.recipes = response.data.data;
                    this.username = response.data.userName;
                    this.pagination = response.data.paginator;
                })
                .catch((error) => {
                    this.errorStatus = error.response.statusText;
                    this.errorMsg = error.response.data.message;
                })
        },
        loadPaginatedProducts: function(page) {
            axios.get(`/api/cooks/${this.$route.params.id}/recipes`, { params: { page: page } })
                .then((response) => {
                    this.recipes = response.data.data;
                    this.pagination = response.data.paginator;
                })
                .catch((error) => {
                    this.errorStatus = error.response.statusText;
                    this.errorMsg = error.response.data.message;
                })
        }
    },
    computed: {
        headline: function()  {
            return `${this.username}'s Recipes`;
        }
    }
}
</script>

<style scoped>

</style>
