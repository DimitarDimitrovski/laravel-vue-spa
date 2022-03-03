<template>
    <div class="row">
        <div class="col-md-12 col-lg-8">
            <img :src="`/storage/avatars/${user.image}`" class="img-thumbnail" width="180" height="180"
                 style="display: inline-block; margin-right: 20px" focusble="false" />
            <div style="display: inline-block; vertical-align: middle;">
                <h3>{{ user.name }}</h3>
                <strong>{{ user.city }}</strong><br>
                <strong class="mt-2">{{ user.description }}</strong>
            </div>
        </div>
        <div class="col-md-12 col-lg-4 d-flex align-items-center justify-content-center border-start border-secondary">
            <h3>{{ recipesCount }} Recipes<br />
                <router-link :to="{ name: 'cook-recipes', params: { id: user.id } }"
                             class="text-decoration-none link-success">View All
                </router-link></h3>
        </div>
    </div>
</template>

<script>
export default {
    name: "CookDetails",
    props: ['user', 'recipesCount']
}
</script>

<style scoped>

</style>
