<template>
    <div class="album py-4 bg-white mb-4">
        <div class="container">
            <div v-if="errorStatus" class="alert alert-danger" role="alert">
                <h4>{{ errorStatus }}</h4>
                <p>{{ errorMsg }}</p>
            </div>
            <div v-if="reviews">
                <h4>User reviews for {{ recipeName }}</h4>
                <ul class="list-group">
                    <review v-for="(review, index) in reviews" :review="review" :key="index"></review>
                </ul>
                <div v-if="pagination !== undefined" class="clearfix mt-3">
                    <pagination :pagination="pagination" @loadPaginatedData="loadPaginatedReviews($event)"></pagination>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: "RecipeReviews",
    data() {
        return {
            reviews: [],
            recipeName: '',
            errorStatus: '',
            errorMsg: '',
            pagination: [],
            page: 1,
        }
    },
    mounted() {
        this.loadData();
    },
    methods: {
        loadData: function () {
            axios.get(`/api/recipes/${this.$route.params.id}/reviews`)
            .then((response) => {
                this.reviews = response.data.data;
                this.recipeName = response.data.recipeName;
                this.pagination = response.data.paginator;
            })
            .catch((error) => {
                this.errorStatus = error.response.statusText;
                this.errorMsg = error.response.data.message;
            })
        },
        loadPaginatedReviews: function (page) {
            axios.get(`/api/recipes/${this.$route.params.id}/reviews`, { params: { page: page } })
                .then((response) => {
                    this.reviews = response.data.data;
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

</style>
