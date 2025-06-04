import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/login.css",
                "resources/css/home.css",
                "resources/css/blog.css",
                "resources/css/articles.css",
                "resources/css/AdminBlog.css",
            ],
            refresh: true,
        }),
    ],
});
