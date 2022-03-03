<template>
    <div>
        <navigation />
        <div class="container">
            <div v-if="$route.name !== 'sign-in' && $route.name !== 'register' && $route.name !== 'not-found'" class="row">
                <div class="col-md-12 col-lg-9">
                    <router-view :key="$route.path"></router-view>
                </div>
                <div class="col-md-12 col-lg-3">
                    <div>
                        <recipes :key="recipesKey" action="latest"></recipes>
                    </div>
                    <div>
                        <latest-comments :key="commentsKey"></latest-comments>
                    </div>
                </div>
            </div>
            <div v-else class="row">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "App",
    data() {
        return {
            recipesKey: 0,
            commentsKey: 0
        }
    },
    mounted() {
        eventBus.$on('recipeRerender', () => {
            this.recipesKey += 1;
        });
        eventBus.$on('rerenderComments', () => {
            this.commentsKey += 1;
        });
    },
}
</script>
