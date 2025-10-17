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
    state: () => {
        return {
            host: 'http://localhost:80',
            translatorHost: 'http://localhost:5278',
            token: '',
        }
    },
    persist: true,
})
