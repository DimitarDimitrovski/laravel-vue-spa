<template>
<div>Test</div>
</template>

<script>
export default {
    data: () => {
        return {
            recipes: [],
            errorStatus: '',
            errorMsg: ''
        }
    },
    mounted() {
        this.loadProducts();
    },
    methods: {
        loadProducts: function() {
            axios.get('/api/recipes', { params: { action: 'latest' } })
                .then((response) => {
                    this.recipes = response.data.data;
                })
                .catch((error) => {
                    this.errorStatus = error.response.statusText;
                    this.errorMsg = error.response.data.message;
                })
        }
    }
}
</script>
