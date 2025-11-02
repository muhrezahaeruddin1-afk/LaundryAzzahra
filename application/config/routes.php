<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['default_controller'] = 'dashboard'; // langsung ke dashboard
// $route['login']  = 'auth/login';   // boleh dibiarkan atau dimatikan
// $route['logout'] = 'auth/logout';  // boleh dibiarkan atau dimatikan


$route['laporan']         = 'laporan/index';
$route['laporan/harian']  = 'laporan/harian';
$route['laporan/bulanan'] = 'laporan/bulanan';
$route['order/baru']      = 'order/baru';
$route['default_controller'] = 'dashboard';
$route['api/dashboard/stats'] = 'api/dashboard_stats';


