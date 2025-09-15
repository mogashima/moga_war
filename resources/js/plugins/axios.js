import axios from 'axios'

// env からベース URL を組み立て
const APP_URL = import.meta.env.VITE_APP_URL || 'http://localhost'
const API_BASE = import.meta.env.VITE_API_BASE || ''

// 最終的なベース URL
const API_BASE_URL = `${APP_URL}/${API_BASE}`.replace(/\/+$/, '')

axios.defaults.baseURL = API_BASE_URL
axios.defaults.withCredentials = true

export default axios
