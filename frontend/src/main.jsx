import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import { BrowserRouter } from 'react-router-dom'
import './index.css'
import App from './App.jsx'
import { appBasePath } from './basePath'

createRoot(document.getElementById('root')).render(
  <StrictMode>
    <BrowserRouter basename={appBasePath === '/' ? undefined : appBasePath}>
      <App />
    </BrowserRouter>
  </StrictMode>,
)
