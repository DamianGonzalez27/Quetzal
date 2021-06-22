/**
 * Archivo de configuracion de webpack para la construccion de modulos con React
 *
 * Este archivo se tiene que modificar cada vez que se requiera construir un modulo front nuevo
 *
 * @see https://nodejs.org/api/path.html
 * @see https://webpack.js.org/plugins/html-webpack-plugin/
 * @see https://webpack.js.org/plugins/mini-css-extract-plugin/
 * @see https://es.reactjs.org/
 * @see https://babeljs.io/
 */
 const path = require("path");
 const MiniCSSExtractPlugin = require("mini-css-extract-plugin");
 // const TerserPlugin = require("terser-webpack-plugin");
 const webpack = require("webpack");
 /**
  * Configuracion de webpack
  *
  * Aqui configuramos las rutas en donde se compilara el codigo React
  *
  * @path src
  */
 // ir cambiando el nombre y el archivo de la entrada dependiendo de la vista donde se esté trabajando
 module.exports = {
   mode: "production",
   entry: "./src/home.js",
   output: {
     path: path.resolve(__dirname, "storage/assets/home/"),
     filename: "app.js",
   },
   devtool: "inline-source-map",
   resolve: {
     extensions: [".js", ".jsx"],
   },
   module: {
     rules: [
       {
         test: /\.(js|jsx)$/,
         exclude: /node_modules/,
         use: {
           loader: "babel-loader",
         },
       },
       {
         test: /\.html$/,
         use: [
           {
             loader: "html-loader",
           },
         ],
       },
       {
         test: /\.scss$/,
         use: [
           MiniCSSExtractPlugin.loader,
           "css-loader",
           {
             loader: "sass-loader",
             options: {
               implementation: require("sass"),
             },
           },
         ],
       },
       {
         test: /\.(png|svg|jpg|jpeg|gif)$/,
         use: ["file-loader"],
       },
     ],
   },
   plugins: [
     new MiniCSSExtractPlugin({
       filename: "app.css",
     }),
   ],
   watchOptions: {
     ignored: /node_modules/,
   },
 };
 