import { dirname, resolve } from "node:path";
import { fileURLToPath } from "node:url";
import { defineConfig } from "vite";

const __dirname = dirname(fileURLToPath(import.meta.url));

// Отдельная сборка для темы WordPress: один JS-вход (тот же src/main.js, что
// и у статической версии) вместо шести HTML-страниц, плюс манифест с хешами,
// который functions.php читает сам — вручную прописывать имена файлов не нужно.
export default defineConfig({
  base: "", // абсолютные пути собирает functions.php через get_template_directory_uri()
  build: {
    outDir: resolve(__dirname, "wp-theme/build"),
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: resolve(__dirname, "src/main.js"),
    },
  },
});
