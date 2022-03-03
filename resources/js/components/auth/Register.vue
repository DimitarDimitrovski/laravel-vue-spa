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
                                <form @submit.prevent="submit">
                                    <h2 class="fw-bold text-uppercase">Register</h2>
                                    <p class="text-dark-50 mb-5">Please enter data in the fields below.</p>
                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label float-start" for="name">Name</label>
                                        <input type="text" id="name" name="name" v-model="form.name"
                                               class="form-control form-control-lg" />
                                    </div>
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
                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label float-start" for="password-confirm">Confirm Password</label>
                                        <input type="password" id="password-confirm" name="password_confirmation" v-model="form.password_confirmation"
                                               class="form-control form-control-lg" />
                                    </div>
                                    <button class="btn btn-outline-primary btn-lg px-5" type="submit">Register</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { mapActions } from 'vuex';
export default {
    name: "Register",
    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            },
            errors: [],
            errorReRender: 0
        }
    },
    methods: {
        ...mapActions({
            registerUser: 'auth/registerUser'
        }),
        submit: function() {
            this.registerUser(this.form).then(() => {
                this.$router.replace({ name: 'cook-profile' });
            }).catch((error) => {
                if(error.response.status === 422) {
                    this.errors = error.response.data;
                    this.errorReRender += 1;
                }
            });
        }
    }
}
</script>

<style scoped>

</style>
