<template>
  <v-alert
    v-if="signupError"
    closable
    :text="signupError"
    type="error"
    variant="tonal"
  ></v-alert>
  <div>
    <h2>{{ mode === "signup" ? "Sign Up" : "Edit User" }}</h2>
    <v-form @submit.prevent="submit">
      <v-text-field
        label="Name"
        v-model="name.value.value"
        :error-messages="name.errorMessage.value"
        clearable
      ></v-text-field>
      <v-text-field
        label="Email"
        v-model="email.value.value"
        :error-messages="email.errorMessage.value"
        clearable
      ></v-text-field>
      <v-text-field
        label="Password"
        v-model="password.value.value"
        :error-messages="password.errorMessage.value"
        clearable
        type="password"
        required
      ></v-text-field>
      <v-text-field
        label="Password confirmation"
        v-model="password_confirmation.value.value"
        :error-messages="password_confirmation.errorMessage.value"
        type="password"
        required
        autocomplete="new-password"
      ></v-text-field>

      <v-btn type="submit" color="primary">{{
        mode === "signup" ? "Sign Up" : "Save Changes"
      }}</v-btn>
    </v-form>

    <p v-if="mode == 'signup'">Already have an account?</p>
    <v-btn text @click="submit">{{
      mode === "signup" ? "Login" : "Cancel"
    }}</v-btn>
  </div>
</template>

<script setup>
import { ref, defineProps, watch } from "vue";
import { useField, useForm } from "vee-validate";
import { useRouter } from "vue-router";
import axios from "axios";
const { handleSubmit } = useForm({
  validationSchema: {
    name(value) {
      if (value.length >= 3) return true;

      return "Name must be at least 3 characters long.";
    },
    email(value) {
      if (/^[a-z.-]+@[a-z.-]+\.[a-z]+$/i.test(value)) return true;

      return "Must be a valid e-mail.";
    },
    password(value) {
      if (!value && props.mode === "edit") return true;
      if (
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/i.test(
          value
        )
      )
        return true;

      return "Password must contain at least 8 characters, including uppercase, lowercase letters, numbers and special characters.";
    },
    password_confirmation(value) {
      if (!value && props.mode === "edit") return true;

      if (value === password.value.value) return true;

      return "Passwords do not match.";
    },
  },
});

const email = useField("email");
const password = useField("password");
const name = useField("name");
const password_confirmation = useField("password_confirmation");
const signupError = ref("");
const route = useRouter();
const props = defineProps({
  mode: String,
  userData: Object,
});
watch(
  () => props.userData,
  (newUserData) => {
    if (newUserData) {
      name.value.value = newUserData.name;
      email.value.value = newUserData.email;
    }
  },
  { immediate: true }
);
const submit = handleSubmit((values) => {
  if (props.mode === "signup") {
    // Sign up code
    axios
      .post("api/register", values)
      .then((res) => {
        localStorage.setItem("token", res.data.token);
        localStorage.setItem("email", values.email);

        route.push("/");
      })
      .catch((err) => {
        signupError.value = err.response.data.message;
      });
  } else if (props.mode === "edit") {
    // Edit code
    axios
      .patch(`api/user/${props.userData.id}`, values, {
        headers: {
          Accept: "application/json",
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      })
      .then((res) => {
        console.log(res);
        route.push("/");
      })
      .catch((err) => {
        signupError.value = err.response;
        console.log(signupError.value);
        console.log("Error");
        console.log(err);
      });
  }
});
</script>
