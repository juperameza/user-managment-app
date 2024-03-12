<template>
  <v-btn @click.prevent="add"> Add new user</v-btn>
  <v-card
    v-for="data in data"
    :title="data.name"
    :text="data.email"
    variant="outlined"
  >
    <v-card-actions>
      <v-btn @click.prevent="edit(data.id)">Edit</v-btn>
      <v-btn @click.prevent="deleteUser(data.id)">Delete</v-btn>
    </v-card-actions>
  </v-card>
</template>
<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

const data = ref(null);
const route = useRouter();
onMounted(() => {
  axios
    .get("api/user", {
      headers: {
        Accept: "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    })
    .then((res) => {
      console.log(res.data);
      data.value = res.data;
    });
});

const edit = (id) => {
  route.push(`/users/${id}`);
};

const add = () => {
  route.push("/register");
};

const deleteUser = (id) => {
  axios
    .delete(`api/user/${id}`, {
      headers: {
        Accept: "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    })
    .then((res) => {
      console.log(res);
      data.value = data.value.filter((user) => user.id !== id);
    })
    .catch((err) => {
      console.log(err);
    });
};
</script>
