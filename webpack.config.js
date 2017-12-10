const path = require('path');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');
const ExtractTextPlugin = require("extract-text-webpack-plugin");
//process.traceDeprecation = true;

module.exports = {
  entry: './assets/js/main.js',
  output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, 'assets/dist'),
    publicPath: 'assets/dist/'
  },
  devServer: {
    contentBase: './',
  },
  devtool: 'source-map',
  module: {
    rules: [
      {
        test: /\.js$/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['es2015', 'stage-2'],
          }
        },
        exclude: ['/node_modules/']
      },
      {
        test: /\.scss$/,
        use: ExtractTextPlugin.extract({
          use: [{
            loader: "css-loader?sourceMap"
          }, {
            loader: "sass-loader?sourceMap"
          }],
          // use style-loader in development
          fallback: "style-loader"
        })
      },
      {
        test: /\.vue$/,
        use: {
          loader: 'vue-loader'
        }
      }
    ]
  },
  resolve: {
    alias: {
      vue: 'vue/dist/vue.js'
    }
  },
  plugins: [
    //new UglifyJSPlugin(),
    new ExtractTextPlugin('style.css')
  ]
}