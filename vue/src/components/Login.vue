<script setup lang="ts">
import {onMounted, ref, reactive} from 'vue'
import {useRouter} from 'vue-router'
import {useUserStore} from '@/stores/user'
import axios from 'axios'

const store = useUserStore();
const router = useRouter();

let username = ref(null);
let password = ref(null);

interface ApiResponse {
  token: string; // Or a more specific type for 'data'
  roles: [];
}

onMounted(() => {
  if (store.token) {
    router.push({name: 'home'})
  }
});

async function onSubmit() {

  let postData = {username: null, password: null};
  postData.username = username.value;
  postData.password = password.value;

  try {
    const res = await axios.post('http://localhost:80/user/login', postData, {
      headers: {
        'Content-Type': 'application/json',
      }
    });

    const data: ApiResponse = await res.data;

    store.token = data.token;
    store.username = username.value;
    store.roles = data.roles;

    router.push({name: 'home'})

  } catch (error) {
    console.log(error);
  }

}

</script>

<template>

  <div class="site-login">

    <div class="mt-5 offset-lg-3 col-lg-6">

      <p>Введите имя пользователя и пароль</p>

      <form @submit.prevent="onSubmit" id="login-form">

        <input v-model="username" required>
        <input type="password" v-model="password" required>

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block">Войти</button>
        </div>

      </form>
    </div>
  </div>

</template>
