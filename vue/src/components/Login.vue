<script setup lang="ts">
import {onMounted, ref, reactive} from 'vue'
import {useRouter} from 'vue-router'
import {useUserStore} from '@/stores/user'
import axios from 'axios'

const store = useUserStore();
const router = useRouter();

let username = ref(null);
let password = ref(null);

let errorMessage = ref(null);

interface ApiResponse {
  token: string; // Or a more specific type for 'data'
}

onMounted(() => {
  if (store.token) {
    router.push({name: 'dashboard'})
  }
});

async function onLogin() {

  let postData = {username: null, password: null};
  postData.username = username.value;
  postData.password = password.value;

  try {
    const res = await axios.post(`${store.host}/user/login`, postData, {
      headers: {
        'Content-Type': 'application/json',
      }
    });

    const data: ApiResponse = await res.data;

    localStorage.setItem('userStore',JSON.stringify({'token':data.token}))

    store.token = data.token;

    router.push({name: 'dashboard'})

  } catch (error) {
    errorMessage.value = error.response.data.message;
  }

}

</script>

<template>

  <div class="site-login">

    <div class="mt-5 " style="width:400px;margin:0 auto">



      <form @submit.prevent="onLogin" id="login-form">

        <div class="mb-3">
        <label for="username" class="form-label">Пользователь</label>
        <input v-model="username" id="username" class="form-control" required>
        </div>
        <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password" v-model="password" id="password" class="form-control" required>
        </div>

        {{errorMessage}}

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block">Войти</button>
        </div>

      </form>
    </div>
  </div>

</template>
