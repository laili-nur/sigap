<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route[''] = 'home';
$route['404_override'] = 'error404';
$route['translate_uri_dashes'] = FALSE;
$route['institute/(:num)'] = 'institute/index/$1';
$route['bank/(:num)'] = 'bank/index/$1';
$route['faculty/(:num)'] = 'faculty/index/$1';
$route['reviewer/(:num)'] = 'reviewer/index/$1';
$route['author/(:num)'] = 'author/index/$1';
$route['draft/(:num)'] = 'draft/index/$1';
$route['worksheet/(:num)'] = 'worksheet/index/$1';
$route['category/(:num)'] = 'category/index/$1';
$route['responsibility/(:num)'] = 'responsibility/index/$1';
$route['user/(:num)'] = 'user/index/$1';
$route['theme/(:num)'] = 'theme/index/$1';
$route['book/(:num)'] = 'book/index/$1';



$route['workunit'] = 'work_unit';
$route['workunit/(:num)'] = 'work_unit/index/$1';
$route['workunit/add'] = 'work_unit/add';
$route['workunit/edit/(:num)'] = 'work_unit/edit/$1';
$route['workunit/delete/(:num)'] = 'work_unit/delete/$1';


$route['draftauthor'] = 'draft_author';
$route['draftauthor/addmulti'] = 'draft_author/addmulti';
$route['draftauthor/(:num)'] = 'draft_author/index/$1';
$route['draftauthor/add'] = 'draft_author/add';
$route['draftauthor/add/(:num)'] = 'draft_author/add/$1';
$route['draftauthor/edit/(:num)'] = 'draft_author/edit/$1';
$route['draftauthor/delete/(:num)'] = 'draft_author/delete/$1';


$route['draftreviewer'] = 'draft_reviewer';
$route['draftreviewer/(:num)'] = 'draft_reviewer/index/$1';
$route['draftreviewer/add'] = 'draft_reviewer/add';
$route['draftreviewer/add/(:num)'] = 'draft_reviewer/add/$1';
$route['draftreviewer/edit/(:num)'] = 'draft_reviewer/edit/$1';
$route['draftreviewer/delete/(:num)'] = 'draft_reviewer/delete/$1';