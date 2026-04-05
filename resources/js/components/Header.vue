<script setup>
import { computed } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const isLoggedIn = computed(() => {
    return !!localStorage.getItem('token');
});

const logoutUser = () => {
    fetch('/api/v1/logout', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
    })
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {
        localStorage.removeItem('token');
        router.push('/login').then(() => {
            window.location.reload();
        })
        
    })
    .catch(function (error) {
        console.log(error);
    });
};

</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">COMP3385</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
           <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <RouterLink class="nav-link" :class="{ active: $route.path === '/' }" to="/">Home</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="nav-link" :class="{ active: $route.path === '/about' }" to="/about">About</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="nav-link" :class="{ active: $route.path === '/movies/create' }" to="/movies/create">Add Movie</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="nav-link" :class="{ active: $route.path === '/movies' }" to="/movies">Movies</RouterLink>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li v-if="!isLoggedIn" class="nav-item">
                        <RouterLink class="nav-link" :class="{ active: $route.path === '/login' }" to="/login">Login</RouterLink>
                    </li>
                    <li v-else class="nav-item">
                        <a href="#" class="nav-link" @click.prevent="logoutUser">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

