<template>
    <div class="album p-4 bg-white">
        <div v-if="errors" v-for="error in errors">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <form @submit.prevent="sendProfileData">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" v-model="form.name">
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" id="city" name="city" class="form-control" v-model="form.city">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Bio info</label>
                <input type="text" id="description" name="description" class="form-control" v-model="form.description">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Choose avatar</label>
                <input class="form-control" type="file" accept="image/*" id="image" name="image" v-on:change="onImageChange">
                <div class="mt-3">
                    <img id="userAvatar" class="img-thumbnail" width="200" :src="`/storage/avatars/${this.userData.image}`">
                </div>
            </div>
            <button type="submit" class="btn btn-outline-primary">Edit Info</button>
        </form>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
export default {
    name: "EditProfile",
    data() {
        return {
            form: {
                id: null,
                name: '',
                city: '',
                description: '',
                image: null
            },
            errors: []
        }
    },
    mounted() {
        this.form.id = this.userData.id
        this.form.name = this.userData.name;
        this.form.city = this.userData.city;
        this.form.description = this.userData.description;
    },
    methods: {
        ...mapActions({
            updateUserData: 'auth/updateUserState'
        }),
        onImageChange: function(event) {
            if(event.target.files) {
                this.form.image = event.target.files[0];
                document.getElementById('userAvatar').src = URL.createObjectURL(event.target.files[0]);
            }
        },
        sendProfileData: async function () {
            const formData = new FormData();
            formData.append("_method", 'PATCH');
            formData.append('id', this.form.id);
            formData.append('name', this.form.name);
            formData.append('city', this.form.city);
            formData.append('description', this.form.description);

            if(this.form.image !== null) {
                formData.append('image', this.form.image);
            }

            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            try {
                await axios.post('/api/cooks/edit-profile', formData, config).then((response) => {
                    this.updateUserData(response.data);
                    this.$router.replace({ name: 'cook-profile' });
                })
            } catch (e) {
                if (e.response.status === 422) {
                    this.errors = e.response.data.errors;
                }
            }
        }
    },
    computed: {
        ...mapGetters({
            userData: 'auth/user'
        })

    }
}
</script>

<style scoped>

</style>
