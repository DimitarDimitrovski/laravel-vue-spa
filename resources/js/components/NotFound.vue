<template>
    <div class="d-flex align-items-center" style="height: 85vh;">
        <div class="col-12 text-center">
            <h2 class="text-primary display-1">4<i class="far fa-frown-open"></i>4</h2>
            <h2>Whoops. Looks like you lost yourself.</h2>
            <p class="lead text-secondary my-3">We are very sorry for the inconvenience. It looks like you are trying to<br>
                access a page that has been deleted or never even used</p>
            <router-link class="btn btn-outline-primary text-decoration-none" :to="{ name: 'home' }">Back to safety</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "NotFound"
}
</script>

<style scoped>

</style>
