import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react()],
  server: {
    host: '0.0.0.0', // Allow external connections (required for Docker)
    port: 5173,
    strictPort: true, // Exit if port is already in use
    watch: {
      usePolling: true, // Required for Docker on some systems
    },
    // Proxy API calls to backend
    proxy: {
      '/api': {
        target: 'http://backend:80',
        changeOrigin: true,
      }
    }
  },
  preview: {
    host: '0.0.0.0',
    port: 5173,
  }
})