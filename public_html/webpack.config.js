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
        ],
    },
    devServer: {
        static: path.resolve(__dirname, 'public/dist/js'),
        compress: true,
        hot: true,
        port: 8080,
    },
};
