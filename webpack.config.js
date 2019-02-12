var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    //.disableSingleRuntimeChunk()
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .addEntry('js/app', [
        './node_modules/jquery/dist/jquery.slim.js',
        './node_modules/popper.js/dist/umd/popper.min.js',
        './node_modules/bootstrap/dist/js/bootstrap.min.js',
        './node_modules/holderjs/holder.min.js'
    ])
    .addStyleEntry('css/app', [
        './node_modules/bootstrap/dist/css/bootstrap.min.css'
    ])

    .addEntry('js/app_admin', [
        './node_modules/admin-lte/bower_components/jquery/dist/jquery.min.js',
        './node_modules/admin-lte/bower_components/bootstrap/dist/js/bootstrap.min.js',
        './node_modules/admin-lte/dist/js/adminlte.min.js'
    ])
    .addStyleEntry('css/app_admin', [
        './node_modules/admin-lte/bower_components/bootstrap/dist/css/bootstrap.min.css',
        './node_modules/admin-lte/bower_components/font-awesome/css/font-awesome.min.css',
        './node_modules/admin-lte/bower_components/Ionicons/css/ionicons.min.css',
        './node_modules/admin-lte/dist/css/AdminLTE.min.css',
        './node_modules/admin-lte/dist/css/skins/skin-blue.min.css'
    ])

    // uncomment if you use Sass/SCSS files
    // .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
