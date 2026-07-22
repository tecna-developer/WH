import { dirname, resolve } from "node:path";
import { fileURLToPath } from "node:url";
import { defineConfig } from "vite";

const __dirname = dirname(fileURLToPath(import.meta.url));

export default defineConfig({
  build: {
    rollupOptions: {
      input: {
        main: resolve(__dirname, "index.html"),
        shop: resolve(__dirname, "shop.html"),
        contacts: resolve(__dirname, "contacts.html"),
        about: resolve(__dirname, "about.html"),
        product: resolve(__dirname, "product.html"),
        cart: resolve(__dirname, "cart.html"),
      },
    },
  },
});
