<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 */

/**
 * LOGIN CONNECT
 */
Router::connect('/admin', ['controller' => 'admins', 'action' => 'login', 'admin'=>true]);
Router::connect('/sports', ['controller' => 'admins', 'action' => 'login', 'sports'=>true]);
Router::connect('/league', ['controller' => 'admins', 'action' => 'login', 'league'=>true]);
Router::connect('/team', ['controller' => 'admins', 'action' => 'login', 'team'=>true]);
Router::connect('/blogger', ['controller' => 'users', 'action' => 'login', 'blogger'=>true]);

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/', ['controller' => 'pages', 'action' => 'home']);
Router::connect('/Cricket', ['controller' => 'Sports', 'action' => 'sport', 1]);
Router::connect('/Soccer', ['controller' => 'Sports', 'action' => 'sport', 2]);
Router::connect('/Football', ['controller' => 'Sports', 'action' => 'sport', 3]);
Router::connect('/Hockey', ['controller' => 'Sports', 'action' => 'sport', 4]);
Router::connect('/Baseball', ['controller' => 'Sports', 'action' => 'sport', 5]);
Router::connect('/Basketball', ['controller' => 'Sports', 'action' => 'sport', 6]);
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
