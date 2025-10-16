<script setup lang="ts">
import {onMounted, ref, reactive, onUpdated, watch, nextTick} from 'vue'
import {useRouter} from 'vue-router'
import {useUserStore} from '@/stores/user'
import axios from 'axios'
import VueTimePicker from "vue3-timepicker";
import "vue3-timepicker/dist/VueTimepicker.css";

const store = useUserStore();
const router = useRouter();

const props = defineProps(['translator'])

const translator = reactive({});

let weekdaysObj: any = reactive([
  {'day': 'Понедельник'},
  {'day': 'Вторник'},
  {'day': 'Среда'},
  {'day': 'Четверг'},
  {'day': 'Пятница'},
]);

let holidaysObj: any = reactive([
  {'day': 'Суббота'},
  {'day': 'Воскресенье'}
]);

const dataSuccess: any = ref(false);


onMounted(() => {

  if (!props.translator.worktime) {
    if (props.translator.weekdays) {
      props.translator.worktime = weekdaysObj;
    } else {
      props.translator.worktime = holidaysObj;
    }
  }

  props.translator.weekdays = Boolean(props.translator.weekdays);

});

function validate(){
  props.translator.worktime.map(x => {
    if(x.after && x.before) {
      if (x.after.HH >= x.before.HH) {
        x.error = 'Время С должно быть меньше времени До';
      } else {
        x.error = false;
      }
    }else{
      x.error = 'Укажите время работы.';
    }
  })


}


async function onSetSchedule() {

  dataSuccess.value = false;

  validate();

  if (props.translator.worktime.some(x => x.error)) {
    return false;
  }

  let postData = {daysObjs: props.translator.worktime, translatorId: props.translator.id, weekdays: props.translator.weekdays};

  try {
    const res = await axios.post(`${store.host}/translators/set-schedule`, postData, {
      headers: {
        'Authorization': `Bearer ${store.token}`
      }
    });

    const data = await res.data;

    dataSuccess.value = true;


  } catch (error) {
    console.log(error);
  }
}

async function onChangeWeekdays() {

  if (props.translator.weekdays) {
    props.translator.worktime = weekdaysObj;
  } else {
    props.translator.worktime = holidaysObj;
  }
}


</script>


<template class="container">



  <form class="justify-content-end" @submit.prevent="onSetSchedule">
<div class="" style="width:470px;margin:0 auto;text-align:right">
  <label for="isWeekdays">Будни</label>
    <input type="checkbox" id="isWeekdays" @change="onChangeWeekdays" v-model="props.translator.weekdays">
</div>
    <div v-for="(val,index) in props.translator.worktime" :key="val['day']">
      <div class="row justify-content-center" style="min-width:500px">
        <div style="width:150px">{{ val['day'] }}</div>
        <div style="width:auto">
          <VueTimePicker format="HH" v-model="val['after']"/>
          <VueTimePicker format="HH" v-model="val['before']"/>
          <div v-if="val['error']" class="invalid form-text">
            {{val['error']}}
          </div>
        </div>

      </div>
    </div>
    <div class="justify-content-center mt-3" style="width:470px;text-align:right;margin:0 auto">
      <button type="submit" class="btn btn-primary btn-block">Добавить</button>
      <div v-if="dataSuccess">Данные успешно добавлены</div>
    </div>
  </form>

</template>
