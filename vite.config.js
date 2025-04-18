import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import preset from "./vendor/filament/support/tailwind.config.preset";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss({
            presets: [preset],
        }),
    ],
    presets: [preset],
    content: [
        "./app/Filament/**/*.php",
        "./resources/views/filament/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
    ],
    server: {
        port: 3000,
        strictPort: true,
        open: true,
        hmr: {
            protocol: "ws",
            host: "localhost",
            port: 3000,
        },
        fs: {
            allow: [".."],
        },
    },
    preview: {
        port: 8080,
        strictPort: true,
        open: true,
    },
    build: {
        outDir: "public/build",
        sourcemap: true,
        minify: "esbuild",
    },
    resolve: {
        alias: {
            "@": "/resources/js",
            "~": "/resources/css",
        },
    },
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@import "@/styles/variables.scss";`,
            },
        },
        postcss: {
            plugins: [
                require("autoprefixer"),
                require("postcss-import"),
                require("tailwindcss")("./tailwind.config.js"),
            ],
        },
    },
    optimizeDeps: {
        include: ["@heroicons/vue/24/outline", "@tailwindcss/forms"],
    },
    assetsInclude: ["**/*.svg", "**/*.png", "**/*.jpg", "**/*.gif"],
    publicDir: "public",
    cacheDir: "node_modules/.vite",
    clearScreen: false,
    logLevel: "info",
    test: {
        globals: true,
        environment: "jsdom",
        setupFiles: "./tests/setup.js",
        coverage: {
            reporter: ["text", "json", "html"],
            exclude: ["resources/**/*"],
        },
    },
});
