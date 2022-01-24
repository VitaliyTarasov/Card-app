const mix = require('laravel-mix');

mix.extend("graphql", new class {
    dependencies() {
        return ['graphql', 'graphql-tag']
    }

    webpackRules() {
        return {
            test: /\.(graphql|gql)$/,
            exclude: /node_modules/,
            loader: 'graphql-tag/loader'
        }
    }
});

mix.graphql();

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss')
    ])

