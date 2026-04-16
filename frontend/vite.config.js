import { defineConfig, loadEnv } from 'vite'
import react from '@vitejs/plugin-react'
import process from 'node:process'

function normalizeBasePath(value) {
  if (!value || value === '/') {
    return '/'
  }

  return value.endsWith('/') ? value : `${value}/`
}

// https://vite.dev/config/
export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), '')

  return {
    base: normalizeBasePath(env.VITE_BASE_PATH),
    plugins: [react()],
  }
})
