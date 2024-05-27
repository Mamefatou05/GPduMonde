const path = require('path');

module.exports = {
    mode: "development",
    entry: {
        dashboard: "./src/dashboard.ts",
        cargaisons: "./src/cargaisons.ts"
    },
    resolve: {
        extensions: [".ts", ".js"]
    },
    module: {
        rules: [
            {
                test: /\.ts$/,
                use: "ts-loader",
                exclude: /node_modules/
            }
        ]
    },
    output: {
        filename: "[name].js",
        path: path.resolve(__dirname, "dist")
    },
    devServer: {
        contentBase: path.join(__dirname, 'dist'),
        hot: true,
    },
}
