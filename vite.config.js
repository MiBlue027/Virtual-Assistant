import { defineConfig } from 'vite';
import path from 'path';
import javascriptObfuscator from 'vite-plugin-javascript-obfuscator';

export default defineConfig({
    root: 'resources',
    build: {
        outDir: '../public/src/style-js',
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            input: {
                app: path.resolve(__dirname, 'resources/js/app.js'),
                style: path.resolve(__dirname, 'resources/css/style.css'),
            },
            output: {
                entryFileNames: '[name].[hash].js',
                assetFileNames: '[name].[hash].[ext]'
            }
        }
    },
    plugins: [
        process.env.ENV === 'prod' ? javascriptObfuscator({
            compact: true,
            controlFlowFlattening: true,
            deadCodeInjection: true,
            selfDefending: true,
            stringArray: true,
            stringArrayEncoding: ['base64'],
            stringArrayThreshold: 0.75
        }) : null
    ]
});
