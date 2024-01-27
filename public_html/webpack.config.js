// webpack.config.js
const path = require('path');

module.exports = {
    entry: {
        index: './src-fe/index.js',
    },
    output: {
        filename: '[name].bundle.js',
        path: path.resolve(__dirname, 'public/dist/js'),
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                    },
                },
            },
            {
                test: /\.html$/,
                use: ['html-loader'],
            },
        ],
    },
    devServer: {
        contentBase: './dist',
        port: 8080,
    },
};
