<template><UserForm mode="edit" :userData="userData" /></template>

<script lang="ts" setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import axios from "axios";
const route = useRoute();
const id = route.params.id;
const userData = ref({});
const getUser = async () => {
  try {
    const response = await axios.get(`api/users/${id}`, {
      headers: {
        Accept: "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    userData.value = response.data;
  } catch (error) {}
};
onMounted(async () => {
  await getUser();
});
</script>
