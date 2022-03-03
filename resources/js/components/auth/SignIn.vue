<template>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-white text-dark" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <div v-if="errors.length !== 0">
                                    <validation-errors :errors="errors" :key="errorReRender" />
                                </div>
                                <div v-if="errMsgStatus" class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <span>{{ errorMessage }}</span>
                                    <button type="button" class="btn-close" v-on:click.prevent="errMsgStatus = !errMsgStatus"></button>
                                </div>
                                <form @submit.prevent="submit">
                                    <h2 class="fw-bold text-uppercase">Login</h2>
                                    <p class="text-dark-50 mb-5">Please enter your email and password!</p>
                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label float-start" for="email">Email</label>
                                        <input type="email" id="email" name="email" v-model="form.email"
                                               class="form-control form-control-lg" />
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label float-start" for="password">Password</label>
                                        <input type="password" id="password" name="password" v-model="form.password"
                                               class="form-control form-control-lg" />
                                    </div>
                                    <p class="small pb-lg-2">
                                        <router-link :to="{ name: 'forgot-password' }" class="text-dark-50">Forgot password?</router-link>
                                    </p>
                                    <button class="btn btn-outline-primary btn-lg px-5" type="submit">Login</button>
                                </form>
                            </div>
                            <div>
                                <p class="mb-0">Don't have an account?
                                    <router-link :to="{ name: 'register' }" href="#" class="text-dark-50 fw-bold">Sign Up</router-link>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { mapActions } from 'vuex'
export default {
    name: "SignIn",
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            errors: [],
            errorReRender: 0,
            errorMessage: '',
            errMsgStatus: false
        }
    },
    methods: {
        ...mapActions({
            signIn: 'auth/signIn'
        }),
        submit: function() {
            this.signIn(this.form).then(() => {
                this.$router.replace({ name: 'cook-profile' });
            }).catch((error) => {
                if(error.response.status === 422) {
                    this.errorMessage = '';
                    this.errors = error.response.data;
                    this.errorReRender += 1;
                } else {
                    this.errors = [];
                    this.errMsgStatus = true;
                    this.errorMessage = error.response.data.message;
                }
            });
        }
    }
}
</script>

<style scoped>

</style>
