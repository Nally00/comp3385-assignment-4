<template>
    <div class="container py-4">
        <h3 class="mb-4">Movies</h3>

        <div class="row">
            <div
                v-for="movie in movies"
                :key="movie.id"
                class="col-md-6 mb-4"
            >
                <div class="card h-100">
                
                    <div class="row g-0">
                        <div class="col-4">
                            <img
                                :src="`/storage/${movie.poster}`"
                                class="img-fluid h-100 w-100"
                                :alt="movie.title"
                                style="object-fit: cover;"
                            >
                        </div>

                        <div class="col-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ movie.title }}</h5>
                                <p class="card-text">{{ movie.description }}</p>
                            </div>   
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>    
</template>


<script setup>
import { ref, onMounted } from "vue";
const movies = ref([]);

const fetchMovies = () => {
  fetch('/api/v1/movies', {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
    }
  })
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {
        movies.value = data.movies;
    })
    .catch(function (error) {
        console.log(error);
    });
};

onMounted(() => {
    fetchMovies();
});





















</script>