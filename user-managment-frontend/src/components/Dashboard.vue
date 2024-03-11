<template>
  <v-card
    v-for="data in data"
    :title="data.name"
    :text="data.email"
    variant="outlined"
  >
    <v-card-actions>
      <v-btn @click.prevent="edit(data.id)">Edit</v-btn>
    </v-card-actions>
  </v-card>
</template>
<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const data = ref(null);
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
  console.log(id);
};
</script>
