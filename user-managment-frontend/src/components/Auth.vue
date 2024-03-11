<template>
  <v-alert
    v-if="loginError"
    closable
    :text="loginError"
    type="error"
    variant="tonal"
  ></v-alert>
  <div v-if="!isLoggedIn">
    <h2>Login</h2>
    <v-form @submit.prevent="submit">
      <v-text-field
        label="Email"
        v-model="email.value.value"
        :error-messages="email.errorMessage.value"
      ></v-text-field>
      <v-text-field
        label="Password"
        v-model="password.value.value"
        :error-messages="password.errorMessage.value"
        type="password"
        required
      ></v-text-field>
      <v-btn type="submit" color="primary">Login</v-btn>
    </v-form>

    <p>Don't have an account?</p>
    <v-btn text href="/register">Sign Up</v-btn>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useField, useForm } from "vee-validate";
import axios from "axios";
const { handleSubmit } = useForm({
  validationSchema: {
    email(value) {
      if (/^[a-z.-]+@[a-z.-]+\.[a-z]+$/i.test(value)) return true;

      return "Must be a valid e-mail.";
    },
    password(value) {
      if (value.length > 0) return true;

      return "Password is required.";
    },
  },
});

const email = useField("email");
const password = useField("password");
const loginError = ref("");
const submit = handleSubmit((values) => {
  axios
    .post("api/login", values)
    .then((res) => {
      if (res.status === 200) {
        localStorage.setItem("token", res.data.access_token);
      }
    })
    .catch((err) => {
      loginError.value = err.response.data.error;
      console.log(err);
    });
});
</script>
