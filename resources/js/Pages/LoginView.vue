<template>
  <div class="container py-4">
    <h3 class="mb-4">Login</h3>

    <div v-if="successMessage" class="alert alert-success">
      {{ successMessage }}
    </div>

    <div v-if="Object.keys(errors).length" class="alert alert-danger">
      <ul class="mb-0">
        <li v-for="(messages, field) in errors" :key="field">
          <span v-for="message in messages" :key="message">
            {{ message }}
          </span>
        </li>
      </ul>
    </div>

    <form @submit.prevent="loginUser">
      <div class="form-group mb-3">
        <label for="email" class="form-label">Email</label>
        <input
          type="email"
          id="email"
          class="form-control"
          v-model="form.email"
        >
      </div>

      <div class="form-group mb-3">
        <label for="password" class="form-label">Password</label>
        <input
          type="password"
          id="password"
          class="form-control"
          v-model="form.password"
        >
      </div>

      <button type="submit" class="btn btn-primary">Login</button>
    </form>
  </div>
</template>


<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const form = ref({
  email: '',
  password: ''
});

const successMessage = ref('');
const errors = ref({});

const loginUser = () => {

  localStorage.removeItem('token');

  fetch('/api/v1/login', {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      email: form.value.email,
      password: form.value.password
    })
  })
    .then(function (response) {
      return response.json();
    })
    
    .then(function (data) {
      if (data.errors) {
        errors.value = data.errors;
        successMessage.value = '';
      } else if (data.access_token) {
        localStorage.setItem('token', data.access_token);
        successMessage.value = 'Login successful';
        errors.value = {};
        router.push('/movies').then(() => {
          window.location.reload();
        });
      } else {
        errors.value = {
          login: ['Invalid Credentials']
        };
        successMessage.value = '';
      }
    })
    .catch(function (error) {
      console.log(error);
    });
};


</script>