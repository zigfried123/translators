<script setup lang="ts">
import TheWelcome from '../components/Login.vue'
import {onMounted, ref, reactive, computed, watch} from 'vue'
import {useRouter} from 'vue-router';
import {useUserStore} from '@/stores/user'
import axios from 'axios'
import VueTimePicker from "vue3-timepicker";
import "vue3-timepicker/dist/VueTimepicker.css";
import Schedule from '../components/Schedule.vue'
import Translators from '../components/Translators.vue'

const store = useUserStore();
const router = useRouter();

let username = ref(null);
let roles = reactive([]);
let translator = {id: null, is_weekdays: true, worktime: []};



onMounted(async () => {
  if (!store.token) {
    return router.push({name: 'login'})
  }

  await getUserdata();

  await getTranslatorServiceData();

});

async function getTranslatorServiceData() {
  const res = await axios.get(`${store.translatorHost}/translator-list`, {
  });

  const data = await res.data;

  return data;
}

async function getUserdata(){
  const res = await axios.get(`${store.host}/user/userdata-by-token`, {
    headers: {
      'Authorization': `Bearer ${store.token}`
    }
  });

  const data = await res.data;

  username.value = data.username;
  roles = data.roles;
  translator = data.translator;
}

async function onLogout() {

  try {
    const res = await axios.post(`${store.host}/user/logout`, {},{
      headers: {
        'Authorization': `Bearer ${store.token}`,
        'Content-Type': 'application/json',
      }
    });

    const data = await res.data;

    delete store.token
    localStorage.removeItem('userStore')

    router.push({name: 'login'})

  } catch (error) {
    console.log(error);
  }

}



</script>

<template>
  Выполнен вход в систему пользователем {{ username }} роль {{ roles[0] }}
  <a @click="onLogout" class="btn btn-primary btn-block">Выйти</a>


  <h2 align="center">Расписание</h2>



  <div v-if="roles[0]=='translator'">
    <Schedule  :translator="reactive(translator)"/>
  </div>


  <div v-if="roles[0]=='admin'">
    <Translators />
  </div>





</template>
