import {defineConfig} from "vite";
import react from "@vitejs/plugin-react";
import {resolve} from "path";

export default defineConfig(({mode}) => ({
    plugins: [react()],
    root: "Resources/Private/ApiPlatformAdmin",
    publicDir: false,
    server: {
        host: true,
    },
    build: {
        outDir: "../../Public/ApiPlatformAdmin/dist",
        emptyOutDir: true,
        sourcemap: mode === "development",
        rollupOptions: {
            input: resolve(__dirname, "Resources/Private/ApiPlatformAdmin/src/index.tsx"),
            output: {
                entryFileNames: "index.js",
                assetFileNames: "[name][extname]",
            },
        },
    },
    base: "./",
}));
