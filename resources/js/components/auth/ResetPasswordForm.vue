<template>
    <div class="container">
        <div v-if="modal" id="success-modal" style="display: block; background-color: rgb(0 0 0 / 25%);" role="dialog"
             class="modal fade show" aria-modal="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Success!</h3>
                    </div>
                    <div class="modal-body">
                        <h5>{{ successMessage }}</h5>
                    </div>
                    <div class="modal-footer">
                        <router-link v-if="authUser === null" :to="{ name: 'sign-in' }" type="button" class="btn btn-primary">OK</router-link>
                        <router-link v-else :to="{ name: 'cook-profile' }" type="button" class="btn btn-primary">OK</router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card card-default">
                    <div class="card-header">New Password</div>
                    <div class="card-body">
                        <validation-errors v-if="errorStatus" :errors="errors" :key="errorReRender" />
                        <form autocomplete="off" @submit.prevent="resetPassword" method="post">
                            <div class="form-group mb-3">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" class="form-control" v-model="email" required disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control" v-model="password" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" v-model="password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
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
    name: "ResetPasswordForm",
    data() {
        return {
            email: '',
            password: '',
            password_confirmation: '',
            errorStatus: false,
            errors: [],
            errorReRender: 0,
            modal: false,
            successMessage: ''
        }
    },
    mounted() {
        const queryString = window.location.search;

        if(queryString) {
            const urlParams = new URLSearchParams(queryString);
            const email = urlParams.get('email');

            if(email) {
                this.email = email;
            }
        }
    },
    methods: {
        resetPassword: async function () {
            let formData = new FormData();
            formData.append('token', this.$route.params.token);
            formData.append('email', this.email);
            formData.append('password', this.password);
            formData.append('password_confirmation', this.password_confirmation);

            try {
                const response = await axios.post('/api/password/reset', formData);

                if(response.status === 200) {
                    this.modal = true;
                    this.successMessage = response.data.success.message;
                }
            } catch (error) {
                if (error.response.status === 422) {
                    this.errorStatus = true;
                    this.errors = error.response.data;
                    this.errorReRender += 1;
                }
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
