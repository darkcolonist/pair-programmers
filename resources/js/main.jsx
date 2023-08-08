import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import { createRoot } from 'react-dom/client'
import App from './App';
import './Index.css';

if (document.getElementById('root')) {
  createRoot(document.getElementById('root')).render(<App />)
}
