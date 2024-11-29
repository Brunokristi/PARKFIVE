<template>
    <div class="container mt-5">
        <h1>Register</h1>
        <form @submit.prevent="handleRegister">
            <div class="form-group mb-3">
                <label for="name">Name</label>
                <input
                    type="text"
                    id="name"
                    v-model="form.name"
                    class="form-control"
                    required
                />
            </div>
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    v-model="form.email"
                    class="form-control"
                    required
                />
            </div>
            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    v-model="form.password"
                    class="form-control"
                    required
                />
            </div>
            <div class="form-group mb-3">
                <label for="password_confirmation">Confirm Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    class="form-control"
                    required
                />
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <a href="{{ route('google.redirect') }}" class="btn btn-danger w-100 mt-3">
            <img
                src="https://developers.google.com/identity/images/g-logo.png"
                alt="Google Logo"
                style="width: 20px; margin-right: 8px;"
            />
            Register with Google
        </a>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            },
        };
    },
    methods: {
        async handleRegister() {
            try {
                const response = await axios.post('/register', this.form);
                console.log(response.data); // Debug the response
            } catch (error) {
                console.error('Error during registration:', error);
            }
        },
    },
};
</script>
