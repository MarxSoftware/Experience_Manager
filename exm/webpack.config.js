const path = require('path');

var config = {
    module: {},
};

var trackerConfig = Object.assign({}, config, {
    mode: 'production',
    entry: "./src/tracker.js",
    resolve: {
        extensions: ['.tsx', '.ts', '.js'],
    },
    output: {
        filename: 'tracker.js',
        path: path.resolve(__dirname, 'dist'),
    },
});
var exmConfig = Object.assign({}, config, {
    mode: 'production',
    entry: './src/exm/exm.js',
    output: {
        filename: 'exm.js',
        path: path.resolve(__dirname, 'dist'),
        library: 'EXM',
    },
    resolve: {
        extensions: ['.tsx', '.ts', '.js'],
    },
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                use: 'ts-loader',
                exclude: /node_modules/,
            },
            {
                test: /\.s[ac]ss$/i,
                use: [
                    // Creates `style` nodes from JS strings
                    'style-loader',
                    // Translates CSS into CommonJS
                    'css-loader',
                    // Compiles Sass to CSS
                    'sass-loader',
                ],
            },
        ],
    },
});

module.exports = [
    exmConfig, trackerConfig,       
];