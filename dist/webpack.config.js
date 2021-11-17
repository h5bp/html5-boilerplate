const HtmlWebpackPlugin =  require('html-webpack-plugin');
module.exports = {
    entry : "./js/main.js",
    devServer: {
        liveReload: true,
        watchContentBase: true,
        inline: true,
        hot: true,
      },
      plugins: [
        new HtmlWebpackPlugin({
            template: './index.html'
        })
    ]
 };