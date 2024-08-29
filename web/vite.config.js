import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import reactRefresh from "@vitejs/plugin-react-refresh";
import react from "@vitejs/plugin-react";
import path from "path";

export default ({ command }) => ({
    base: command === "serve" ? "" : "/build/",
    publicDir: "fake_dir_so_nothing_gets_copied",
    build: {
        manifest: true,
        outDir: "public/build",
        rollupOptions: {
            input: ["resources/scss/crm.scss", "resources/js/crm.jsx"],
        },
    },
    plugins: [
        laravel({
            input: ["resources/scss/crm.scss", "resources/js/crm.jsx"],
            refresh: true,
        }),
        reactRefresh(),
    ],
});
