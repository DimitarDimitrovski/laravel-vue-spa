<template>
    <div>
        <div class="album p-4 bg-white mb-4">
            <div class="container">
                <div v-if="errorStatus" class="alert alert-danger" role="alert">
                    <h4>{{ errorStatus }}</h4>
                    <p>{{ errorMsg }}</p>
                </div>
                <div class="row">
                    <cook-details :user="user" :recipesCount="recipesCount" />
                </div>
            </div>
        </div>
        <div class="album p-4 bg-white mb-4">
            <div v-if="user.Recipes">
                <h4>User's latest recipes</h4>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <div v-for="recipe in user.Recipes" class="col">
                        <recipe :recipe="recipe" action="cook" :details="false"></recipe>
                    </div>
                </div>
            </div>
            <div v-else>
                <h4>User has not posted any recipes yet.</h4>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Cook",
    data: () => {
        return {
            errorStatus: '',
            errorMsg: '',
            user: () => ({}),
            recipesCount: 0,
        }
    },
    mounted() {
        this.loadData();
    },
    methods: {
        loadData: function() {
            let self = this;
            axios.get(`/api/cooks/${this.$route.params.id}`)
                .then((response) => {
                    this.user = response.data.data;
                    this.recipesCount = response.data.recipesCount;
                }).catch((error) => {
                    if(error.response.status === 404) {
                        self.$router.push({ name: 'not-found'});
                    }

                    this.errorStatus = error.response.statusText;
                    this.errorMsg = error.response.data.message;
            })
        }
    }
}
</script>

<style scoped>

</style>
