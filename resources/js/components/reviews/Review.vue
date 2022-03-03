<template>
    <li class="list-group-item d-flex flex-row">
        <div class="me-2">
            <img class="rounded-circle" width="50" height="50"
                 :src="`/storage/avatars/${review.User.image}`" />
        </div>
        <div class="flex-fill">
            <div class="rating-stars" :style="`--rating: ${review.rating}`"></div>
            <strong>{{ review.title }}</strong>
            <p>{{ review.description }}</p>
        </div>
    </li>
</template>

<script>
export default {
    name: "Review",
    props:['review']
}
</script>

<style scoped>

</style>
