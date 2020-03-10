<template>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-md-between">

                    Edit Profile

                    <router-link :to="{ name: 'landingPage'}" class="btn btn-sm btn-dark ml-2"> Back </router-link>

                </div>

                <div class="card-body">
                    
                    <form @submit.prevent="updateProfile">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="" v-model="user.name" required autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control disabled" :value="user.email"  disabled>
                                <input id="email" type="hidden" class="form-control disabled" name="email" value="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="street" class="col-md-4 col-form-label text-md-right">Street</label>

                            <div class="col-md-6">
                                <input id="street" type="text" class="form-control" name="street" v-model="user.street"  required autocomplete="street" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="house_number" class="col-md-4 col-form-label text-md-right">House Number</label>

                            <div class="col-md-6">
                                <input id="house_number" type="text" class="form-control" name="house_number" value="" v-model="user.house_number"  required autocomplete="house_number" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="post_code" class="col-md-4 col-form-label text-md-right">Post Code</label>

                            <div class="col-md-6">
                                <input id="post_code" type="text" class="form-control" name="post_code" value="" v-model="user.post_code"  required autocomplete="post_code" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city" class="col-md-4 col-form-label text-md-right">City</label>

                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control" name="city" value="" v-model="user.city"  required autocomplete="city" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="country" class="col-md-4 col-form-label text-md-right">Country</label>

                            <div class="col-md-6">
                                <input id="country" type="text" class="form-control" name="country" value="" v-model="user.country"  required autocomplete="country" autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-dark">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                user: [],
            }
        },
        created() {

            this.axios
                .get(`/api/edit/profile`)
                .then((response) => {
                    this.user = response.data.user;
                });
        },

        methods: {

            updateProfile() {
                var that = this;

                this.axios
                    .post('/api/edit/profile/update',
                        {name : this.user.name, 
                         street : this.user.street,
                         house_number : this.user.house_number, 
                         post_code : this.user.post_code, 
                         city : this.user.city,
                         country : this.user.country})
                    .then(response => (
                        setTimeout(() => that.$router.push({name: 'landingPage'}), 200),

                        alert('Profile update sucessfully')
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)   
            }
        }
    }
</script>