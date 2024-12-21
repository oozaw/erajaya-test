const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/app.css", "public/css", [
        require("tailwindcss"),
    ])
    .webpackConfig({
        stats: {
            children: true
        },
        resolve: {
            alias: {
                'jquery': require.resolve('jquery'),
            }
        }
   })
    .options({
        watchOptions: {
            ignored: [
                /node_modules/,
                /public/,
            ],
        }
     });

mix.browserSync({
    proxy: "http://localhost:8000",
    files: [
        "resources/views/**/*.blade.php",
        "public/**/*.*"
    ],
    open: false
});
