<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['apexchart'] = 'apexchart/apex';
$route['test'] = 'test/tester';
$route['test/(:any)'] = 'test/tester/$1';
$route['news/create'] = 'news/create';
$route['news/(:any)'] = 'news/view/$1';
$route['news'] = 'news';

$route['about'] = 'pages/view';

$route['phpinfo'] = 'phpinfo/index';
$route['default_controller'] = 'pages/view';
$route['(:any)'] = 'Pages/view/$1';
//$route['(:any)'] = 'Pages/view/about';