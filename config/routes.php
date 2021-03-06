<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

$routes->connect('/transaction', ['controller' => 'Admin', 'action' => 'transaction']);

$routes->connect('/profile/', ['controller' => 'Admin', 'action' => 'profile']);
$routes->connect('/details/id', ['controller' => 'Admin', 'action' => 'details']);
$routes->connect('/edit/id', ['controller' => 'Admin', 'action' => 'editpost']);
$routes->connect('/viewpost', ['controller' => 'Admin', 'action' => 'viewpost']);
$routes->connect('/wallet/*', ['controller' => 'Admin', 'action' => 'wallet']);
$routes->connect('/post', ['controller' => 'Admin', 'action' => 'post']);
$routes->connect('/admin', ['controller' => 'Admin', 'action' => 'index']);

$routes->connect('/api/getNotice', ['controller' => 'Api', 'action' => 'getNotice']);
$routes->connect('/api', ['controller' => 'Api', 'action' => 'index']);
$routes->connect('/api/signup', ['controller' => 'Api', 'action' => 'signup']);
$routes->connect('/api/contact', ['controller' => 'Api', 'action' => 'contact']);


$routes->connect('/api/login', ['controller' => 'Api', 'action' => 'login']);
$routes->connect('/api/gettest', ['controller' => 'Api', 'action' => 'gettest']);
$routes->connect('/api/getexamdata', ['controller' => 'Api', 'action' => 'getexamdata']);
$routes->connect('/api/profile', ['controller' => 'Api', 'action' => 'profile']);
$routes->connect('/api/getExam', ['controller' => 'Api', 'action' => 'getExam']);
$routes->connect('/api/getExamSubject', ['controller' => 'Api', 'action' => 'getExamSubject']);
$routes->connect('/api/getExamChapters', ['controller' => 'Api', 'action' => 'getExamChapters']);
$routes->connect('/api/getBanner', ['controller' => 'Api', 'action' => 'getBanner']);
$routes->connect('/api/sendmail', ['controller' => 'Api', 'action' => 'sendmail']);

$routes->connect('/api/setTestimonial', ['controller' => 'Api', 'action' => 'setTestimonial']);
$routes->connect('/api/getTestimonial', ['controller' => 'Api', 'action' => 'getTestimonial']);

$routes->connect('/api/getclass', ['controller' => 'Api', 'action' => 'getclass']);
$routes->connect('/api/getsubject', ['controller' => 'Api', 'action' => 'getsubject']);
$routes->connect('/api/getexcersice', ['controller' => 'Api', 'action' => 'getexcersice']);
$routes->connect('/api/setTestResult', ['controller' => 'Api', 'action' => 'setTestResult']);
$routes->connect('/api/getTestHistory', ['controller' => 'Api', 'action' => 'getTestHistory']);
$routes->connect('/api/getMaterials', ['controller' => 'Api', 'action' => 'getMaterials']);
$routes->connect('/api/getCategory', ['controller' => 'Api', 'action' => 'getCategory']);
$routes->connect('/api/getEbook', ['controller' => 'Api', 'action' => 'getEbook']);
$routes->connect('/api/getSubcategory', ['controller' => 'Api', 'action' => 'getSubcategory']);

$routes->connect('/api/changepassword', ['controller' => 'Api', 'action' => 'changepassword']);
$routes->connect('/api/forgot', ['controller' => 'Api', 'action' => 'forgot']);

$routes->connect('/banner', ['controller' => 'Upload', 'action' => 'banner']);

$routes->connect('/contact', ['controller' => 'Admin', 'action' => 'contact']);
$routes->connect('/upload', ['controller' => 'Upload', 'action' => 'upload']);

$routes->connect('/getdata', ['controller' => 'Docupload', 'action' => 'getdata']);
$routes->connect('/docupload', ['controller' => 'Docupload', 'action' => 'index']);
$routes->connect('/docupload/materials', ['controller' => 'Docupload', 'action' => 'materials']);
$routes->connect('/docupload/edit', ['controller' => 'Docupload', 'action' => 'edit']);
$routes->connect('/docupload/exammaterials', ['controller' => 'Docupload', 'action' => 'exammaterials']);
$routes->connect('/generatetest', ['controller' => 'Generate', 'action' => 'index']);
$routes->connect('/generateexam', ['controller' => 'Generate', 'action' => 'generateexam']);

$routes->connect('/generatetest/add', ['controller' => 'Generate', 'action' => 'add']);
$routes->connect('/generatetest/view', ['controller' => 'Generate', 'action' => 'view']);
$routes->connect('/generatetest/fullsyllabus', ['controller' => 'Generate', 'action' => 'fullsyllabus']);
$routes->connect('/generatetest/edit', ['controller' => 'Generate', 'action' => 'edit']);
$routes->connect('/', ['controller' => 'Main', 'action' => 'login']);





$routes->connect('/post/category', ['controller' => 'Post', 'action' => 'category']);
$routes->connect('/login', ['controller' => 'Main', 'action' => 'login']);
$routes->connect('/reset', ['controller' => 'Main', 'action' => 'reset']);
$routes->connect('/classadd', ['controller' => 'Admin', 'action' => 'classadd']);
$routes->connect('/subject', ['controller' => 'Admin', 'action' => 'subject']);
$routes->connect('/excersise', ['controller' => 'Admin', 'action' => 'excersise']);
$routes->connect('/edituser', ['controller' => 'Admin', 'action' => 'edituser']);
$routes->connect('/status', ['controller' => 'Admin', 'action' => 'status']);


$routes->connect('/exam/examadd', ['controller' => 'Exam', 'action' => 'examadd']);
$routes->connect('/exam/subject', ['controller' => 'Exam', 'action' => 'subject']);
$routes->connect('/exam/excersise', ['controller' => 'Exam', 'action' => 'excersise']);



$routes->connect('/ebook/index', ['controller' => 'Ebook', 'action' => 'index']);
$routes->connect('/ebook/category', ['controller' => 'Ebook', 'action' => 'category']);
$routes->connect('/ebook/editebook', ['controller' => 'Ebook', 'action' => 'editebook']);
$routes->connect('/ebook/subcategory', ['controller' => 'Ebook', 'action' => 'subcategory']);


$routes->connect('/notice', ['controller' => 'Admin', 'action' => 'notice']);
$routes->connect('/testimonials', ['controller' => 'Admin', 'action' => 'testimonials']);
$routes->connect('/users', ['controller' => 'Admin', 'action' => 'users']);




$routes->connect('/delclass', ['controller' => 'Admin', 'action' => 'delclass']);

$routes->connect('/delsub', ['controller' => 'Admin', 'action' => 'delsub']);

$routes->connect('/delexercise', ['controller' => 'Admin', 'action' => 'delexercise']);
$routes->connect('/exam', ['controller' => 'Admin', 'action' => 'exam']);

$routes->connect('/search/:param1', ['controller' => 'Appreciate', 'action' => 'search'],["pass"=>["param1"]]);
$routes->connect('/register', ['controller' => 'Main', 'action' => 'register']);

$routes->connect('/contact', ['controller' => 'Main', 'action' => 'contact']);

$routes->connect('/post/:param1', ['controller' => 'Post', 'action' => 'post'],["pass"=>["param1"]]);

$routes->connect('/giveappri', ['controller' => 'Post', 'action' => 'giveappri']);

$routes->connect('/forgot', ['controller' => 'Main', 'action' => 'forgot']);

$routes->connect('/logout', ['controller' => 'Main', 'action' => 'logout']);

//$routes->connect('/:param1/:param2', ['controller' => 'Test', 'action' => 'Index', 'index'],["pass"=>["param1","param2"]]);

Router::scope('/', function (RouteBuilder $routes) {
    // Register scoped middleware for in scopes.
    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true
    ]));

    /**
     * Apply a middleware to the current route scope.
     * Requires middleware to be registered via `Application::routes()` with `registerMiddleware()`
     */
    // $routes->applyMiddleware('csrf');

    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    // $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *
     * ```
     * $routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
     * $routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
     * ```
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

/**
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * Router::scope('/api', function (RouteBuilder $routes) {
 *     // No $routes->applyMiddleware() here.
 *     // Connect API actions here.
 * });
 * ```
 */
