<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card card-default">
                    <div class="card-header">Reset Password</div>
                    <div class="card-body">
                        <div v-if="error" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span>{{ errorMessage }}</span>
                            <button type="button" class="btn-close" v-on:click.prevent="error = !error"></button>
                        </div>
                        <div v-if="success" class="alert alert-success alert-dismissible fade show" role="alert">
                            <span>{{ successMsg }}</span>
                            <button type="button" class="btn-close" v-on:click.prevent="success = !success"></button>
                        </div>
                        <form autocomplete="off" @submit.prevent="requestResetPassword" method="post">
                            <div class="form-group mb-3">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    name: "ForgotPassword",
    data() {
        return {
            email: '',
            error: false,
            errorMessage: '',
            success: false,
            successMsg: '',
        }
    },
    mounted() {
        if( this.authUser !== null) {
            this.email = this.authUser.email;
        }
    },
    methods: {
        requestResetPassword() {
            axios.post('/api/password/email', { email: this.email })
            .then((response) => {
                this.success = true;
                this.successMsg = response.data.success.message;
            }).catch((error) => {
                this.error = true;
                this.errorMessage = error.response.data.message;
            })
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
