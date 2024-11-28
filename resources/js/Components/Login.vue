<template>
    <div id="login-page" class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">Login</div>
                    <div class="card-body">
                        <form @submit.prevent="handleLogin">
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" id="email" v-model="form.email" class="form-control" required />
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" id="password" v-model="form.password" class="form-control"
                                    required />
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                email: '',
                password: '',
            },
        };
    },
    methods: {
        async handleLogin() {
            try {
                const response = await axios.post('/login', this.form);
                if (response.status === 200) {
                    window.location.href = '/dashboard';
                }
            } catch (error) {
                alert('Invalid credentials!');
            }
        },
    },
};
</script>

<style>
#login-page {
    margin-top: 50px;
}
</style>
