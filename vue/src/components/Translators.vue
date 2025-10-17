<script setup lang="ts">
import {onMounted, ref, reactive, onUpdated, watch, nextTick} from 'vue'
import {useRouter} from 'vue-router'
import {useUserStore} from '@/stores/user'
import axios from 'axios'


const store = useUserStore();
const router = useRouter();

const date = new Date();
const hour = date.getHours();

const daysObj = [
  {'day': 'Понедельник'},
  {'day': 'Вторник'},
  {'day': 'Среда'},
  {'day': 'Четверг'},
  {'day': 'Пятница'},
  {'day': 'Суббота'},
  {'day': 'Воскресенье'}
]

const daysShort = [
  {'day': 'Пн'},
  {'day': 'Вт'},
  {'day': 'Ср'},
  {'day': 'Чт'},
  {'day': 'Пт'},
  {'day': 'Сб'},
  {'day': 'Вс'}
]


let translators: any = reactive([]);

onMounted(async () => {

  try {
    const res = await axios.get(`${store.host}/translators/get-translators-data`, {
      headers: {
        'Authorization': `Bearer ${store.token}`
      }
    });

    translators.push(...await res.data);


  } catch (error) {
    console.log(error);
  }

});

function findFreeTranslator(worktime: []) {

  if(!worktime) return;

  let todayWorktime = worktime.find(x => {
     return x.day === getDayWeekRu();
  })

  if(todayWorktime?.after?.HH <= hour < todayWorktime?.before?.HH){
    return 'ДА';
  }else{
    return 'Нет'
  }
}

function getDayWeekRu() {
  return daysObj[date.getDay()-1].day;
}

function getDayShort(day) {
  let indexOfDaysObj = daysObj.findIndex(x => x.day === day);
  return daysShort[indexOfDaysObj].day;
}



</script>

<template class="container" style="">


  <table class="table">
    <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Имя</th>
      <th scope="col">Будни?</th>
      <th scope="col">Рабочее время</th>
      <th scope="col">Доступен</th>
    </tr>
    </thead>
    <tbody>


    <tr v-for="translator in translators" :key="translator.id">
      <td>{{ translator.id }}</td>
      <td>{{ translator.username }}</td>
      <td>{{ translator.is_weekdays ? 'да' : 'нет' }}</td>

      <td>
        <div class="mt-0 pt-0 pb-0" style="font-size:12px" v-for="worktime in translator.worktime">{{ getDayShort(worktime.day) }}
          {{ worktime.after.HH }}:00 - {{ worktime.before.HH }}:00
        </div>
      </td>
      <td>
        {{ findFreeTranslator(translator.worktime) }}
      </td>

    </tr>


    </tbody>


  </table>


</template>
