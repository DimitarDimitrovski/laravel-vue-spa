<template>
    <div>
        <div v-for="(field, key) in errors" class="alert alert-danger alert-dismissible fade show"
             role="alert" :key="key">
                <span v-for="error in field" :key="error">
                    {{ error }}
                </span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</template>

<script>
export default {
    name: "ValidationErrors",
    props: ['errors']
}
</script>

<style scoped>

</style>
