<template>
    <div class="bg-white mt-3 p-4">
        <div v-if="errorStatus" class="alert alert-danger" role="alert">
            <h4>{{ errorStatus }}</h4>
            <p>{{ errorMsg }}</p>
        </div>
        <h4>Last Comments</h4>
        <ul class="list-group">
            <li v-for="comment in comments" class="list-group-item">
                {{ comment.created_at }}, <router-link :to="{ name: 'cook', params: { id: comment.User.id }}" class="link-dark text-decoration-none">
                <strong>{{comment.User.name}}</strong></router-link> on
                <strong>
                    <span class="text-primary">
                        <router-link :to="{ name: 'recipe-page', params: { id: comment.Recipe.id }}" class="text-decoration-none">
                            {{comment.Recipe.name}}
                        </router-link>
                    </span>
                </strong>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    data: () => {
        return {
            comments: [],
            errorStatus: '',
            errorMsg: '',
        }
    },
    mounted() {
        this.loadComments();
    },
    methods: {
        loadComments: function () {
            axios.get('/api/comments/latest')
                .then((response) => {
                    this.comments = response.data.data;
                })
                .catch((error) => {
                    this.errorStatus = error.response.statusText;
                    this.errorMsg = error.response.data.message;
                })
        }
    }
}
</script>
