import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/app-rtl.min.css",
                "resources/css/app.min.css",
                "resources/css/bootstrap-rtl.min.css",
                "resources/css/bootstrap.css",
                "resources/css/bootstrap.min.css",
                "resources/css/icons-rtl.min.css",
                "resources/css/icons.css",
                "resources/css/icons.min.css",
            ],
            refresh: true,
        }),
    ],
});
