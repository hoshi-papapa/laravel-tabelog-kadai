// vite.config.js
import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    rollupOptions: {
      output: {
        manualChunks: (id) => {
          // Disable modulepreload
          if (id.includes('node_modules')) {
            return 'vendor';
          }
        }
      }
    }
  }
});
