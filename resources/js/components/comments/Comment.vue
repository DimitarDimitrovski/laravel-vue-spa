<template>
    <div class="card p-3 shadow-sm mt-3" style="margin-bottom: 15px;">
        <div class="d-flex flex-row">
            <div style="width: 100%">
                <img :src="`/storage/avatars/${comment.User.image}`" width="60" height="60"
                     style="display: inline-block" focusble="false" />
                <div style="display: inline-block; vertical-align: middle;">
                    <span v-if="authUser !== null" @click="reply = true" class="text-primary"
                          style="position: absolute; right: 20px"><i class="fa fa-reply"></i> reply</span>
                    <strong>{{ comment.User.name }}</strong><br>
                    <strong>{{ comment.created_at }}</strong><br>
                </div>
                <div>
                    {{ comment.content }}
                </div>
                <div v-if="comment.Replies" class="ps-2">
                    <comment v-for="(c, key) in comment.Replies" :comment="c" :key="key"></comment>
                </div>
                <div v-if="authUser !== null && reply === true">
                    <form @submit.prevent="postReply(comment.id)">
                        <label for="content" class="form-label mt-3 fs-4">Post Reply</label>
                        <div v-if="error" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span>{{ errorMessage }}</span>
                            <button type="button" class="btn-close" v-on:click.prevent="error = !error"></button>
                        </div>
                        <div class="mb-3">
                            <textarea rows="6" style="resize: none;" id="content" name="content" class="form-control"
                                      v-model="content"></textarea>
                        </div>
                        <div v-if="spinner" class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <button style="vertical-align: bottom" class="btn btn-primary" :disabled="disabled">Post Reply</button>
                        <div v-if="success" :class="(success === true) ? 'mt-3 alert alert-success alert-dismissible show' :
            'mt-3 alert alert-success alert-dismissible fade'" role="alert">
                            {{ successMessage }}
                            <button type="button" class="btn-close" v-on:click.prevent="success = !success"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    name: "Comment",
    props: {
        comment: {
            type: Object, default: () => ({})
        }
    },
    data() {
        return {
            reply: false,
            content: '',
            success: false,
            successMessage: '',
            error: false,
            errorMessage: '',
            disabled: false,
            spinner: false
        }
    },
    methods: {
        postReply: async function (id) {
            this.spinner = true;
            let formData = new FormData();
            formData.append('user_id', this.authUser.id);
            formData.append('parent_id', id);
            formData.append('content', this.content);

            try {
                await axios.post('/api/comments/post', formData).then((response) => {
                    if(response.status === 200) {
                        this.success = true;
                        this.successMessage = response.data.message;
                        this.content = '';
                        this.disabled = true;

                        setTimeout(() => {
                            this.disabled = false;
                        }, 180000)
                    }
                })
            }
            catch(e) {
                if (e.response.status === 422) {
                    this.error = true;
                    this.errorMessage = 'Field is required.';
                }
            }
            finally {
                this.spinner = false;
            }
        }
    },
    computed: {
        ...mapGetters({
            authUser: 'auth/user'
        })
    }
}
</script>

<style scoped>

</style>
