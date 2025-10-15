<script setup lang="ts">
import TheWelcome from '../components/Login.vue'
import {onMounted, ref, reactive} from 'vue'
import {useRouter} from 'vue-router';
import {useUserStore} from '@/stores/user'
import axios from 'axios'

const store = useUserStore();
const router = useRouter();


onMounted(async () => {
  if (!store.token) {
    return router.push({name: 'login'})
  }

  const res = await axios.post('http://localhost:80/user/userdata-by-token', {token: store.token}, {
    headers: {
      'Content-Type': 'application/json',
    }
  });

  const data = await res.data;

  console.log(data);
});


</script>

<template>
  Выполнен вход в систему пользователем {{ store.username }} роль {{ store.roles[0] }}


</template>
