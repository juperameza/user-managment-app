<template>
  <v-alert
    v-if="signupError"
    closable
    :text="signupError"
    type="error"
    variant="tonal"
  ></v-alert>
  <div>
    <h2>Sign up</h2>
    <v-form @submit.prevent="submit">
      <v-text-field
        label="Name"
        v-model="name.value.value"
        :error-messages="name.errorMessage.value"
      ></v-text-field>
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
      <v-text-field
        label="Password confirmation"
        v-model="password_confirmation.value.value"
        :error-messages="password_confirmation.errorMessage.value"
        type="password"
        required
      ></v-text-field>
      <v-btn type="submit" color="primary">Sign Up</v-btn>
    </v-form>

    <p>Already have an account?</p>
    <v-btn text href="/">Login</v-btn>
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
      if (
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/i.test(
          value
        )
      )
        return true;

      return "Password must contain at least 8 characters, including uppercase, lowercase letters, numbers and special characters.";
    },
    password_confirmation(value) {
      if (value === password.value.value) return true;

      return "Passwords do not match.";
    },
  },
});

const email = useField("email");
const password = useField("password");
const password_confirmation = useField("password_confirmation");
const name = useField("name");
const signupError = ref("");
const submit = handleSubmit((values) => {
  console.log(values);
  axios
    .post("api/register", values)
    .then((res) => {
      console.log(res);
      if (res.status === 200) {
        localStorage.setItem("token", res.data.token);
        localStorage.setItem("email", values.email);
        window.location.href = "/";
      }
    })
    .catch((err) => {
      signupError.value = err.response.data.error;
      console.log(err);
    });
});
</script>
