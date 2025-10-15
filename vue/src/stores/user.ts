import { ref, reactive, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { useRoute } from 'vue-router'
const route = useRoute();

interface UserState {
    host: string,
    token: string,
    username: string,
    roles: any
}


export const useUserStore = defineStore('userStore', {
    state: () => ({
        host: 'http://localhost:80',
        token: '',
        username: '',
        roles: []
    }),
    persist: true,
    actions: {

    },
});
