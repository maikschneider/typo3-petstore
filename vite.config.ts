import {defineConfig} from "vite";
import react from "@vitejs/plugin-react";

// Source root is Resources/Private/ApiPlatformAdmin; outDir is relative to that root.
export default defineConfig(({mode}) => ({
    plugins: [react()],
    root: "Resources/Private/ApiPlatformAdmin",
    publicDir: false,
    server: {
        host: true,
    },
    build: {
        outDir: "../../Public/ApiPlatformAdmin",
        emptyOutDir: true,
        sourcemap: mode === "development",
        rollupOptions: {
            output: {
                entryFileNames: "index.js",
                assetFileNames: "[name][extname]",
            },
        },
    },
    base: "./",
}));
