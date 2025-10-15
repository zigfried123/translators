<script setup lang="ts">
import TheWelcome from '../components/Login.vue'
import {onMounted, ref, reactive} from 'vue'
import {useRouter} from 'vue-router';
import {useUserStore} from '@/stores/user'

const store = useUserStore();
const router = useRouter();


onMounted(() => {
  if (!store.token) {
    router.push({name: 'login'})
  }
});


</script>

<template>
  Выполнен вход в систему пользователем {{ store.username }} роль {{ store.roles[0] }}


</template>
