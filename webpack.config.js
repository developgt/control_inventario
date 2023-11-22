const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
module.exports = {
  mode: 'development',
  watch: true,
  entry: {
    'js/app' : './src/js/app.js',
    'js/inicio' : './src/js/inicio.js',
    'js/menu/index' : './src/js/menu/index.js',
    'js/almacen/index' : './src/js/almacen/index.js',
    'js/estado/index' : './src/js/estado/index.js',
    'js/medida/index' : './src/js/medida/index.js',
    'js/guarda/index' : './src/js/guarda/index.js',
    'js/producto/index' : './src/js/producto/index.js',
    'js/movimiento/index' : './src/js/movimiento/index.js',
    'js/movegreso/index' : './src/js/movegreso/index.js',
    'js/gestion/index' : './src/js/gestion/index.js',
    'js/guardalmacen/index' : './src/js/guardalmacen/index.js',
    'js/kardex/index' : './src/js/kardex/index.js'

  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'public/build')
  },
  plugins: [
    new MiniCssExtractPlugin({
        filename: 'styles.css'
    })
  ],
  module: {
    rules: [
      {
        test: /\.(c|sc|sa)ss$/,
        use: [
            {
                loader: MiniCssExtractPlugin.loader
            },
            'css-loader',
            'sass-loader'
        ]
      },
      {
        test: /\.(png|svg|jpg|gif)$/,
        loader: 'file-loader',
        options: {
           name: 'img/[name].[hash:7].[ext]'
        }
      },
    ]
  }
};