<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('sitemap.xml', 'Home::sitemap');
$routes->post('api/chat', 'Chat::send');

$adminArea = ADMIN_AREA;

$routes->get($adminArea . '/login', 'Admin\Auth::login');
$routes->post($adminArea . '/login', 'Admin\Auth::attempt');
$routes->get($adminArea . '/logout', 'Admin\Auth::logout');

$routes->group($adminArea, ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');

    $routes->get('projects', 'Admin\Projects::index');
    $routes->get('projects/create', 'Admin\Projects::create');
    $routes->post('projects', 'Admin\Projects::store');
    $routes->get('projects/(:num)/edit', 'Admin\Projects::edit/$1');
    $routes->post('projects/(:num)', 'Admin\Projects::update/$1');
    $routes->post('projects/(:num)/delete', 'Admin\Projects::delete/$1');

    $routes->get('experiences', 'Admin\Experiences::index');
    $routes->get('experiences/create', 'Admin\Experiences::create');
    $routes->post('experiences', 'Admin\Experiences::store');
    $routes->get('experiences/(:num)/edit', 'Admin\Experiences::edit/$1');
    $routes->post('experiences/(:num)', 'Admin\Experiences::update/$1');
    $routes->post('experiences/(:num)/delete', 'Admin\Experiences::delete/$1');

    $routes->get('timeline', 'Admin\Experiences::index');
    $routes->get('timeline/create', 'Admin\Experiences::create');
    $routes->post('timeline', 'Admin\Experiences::store');
    $routes->get('timeline/(:num)/edit', 'Admin\Experiences::edit/$1');
    $routes->post('timeline/(:num)', 'Admin\Experiences::update/$1');
    $routes->post('timeline/(:num)/delete', 'Admin\Experiences::delete/$1');

    $routes->get('skills', 'Admin\Skills::index');
    $routes->get('skills/create', 'Admin\Skills::create');
    $routes->post('skills', 'Admin\Skills::store');
    $routes->get('skills/(:num)/edit', 'Admin\Skills::edit/$1');
    $routes->post('skills/(:num)', 'Admin\Skills::update/$1');
    $routes->post('skills/(:num)/delete', 'Admin\Skills::delete/$1');

    $routes->get('contacts', 'Admin\Contacts::index');
    $routes->get('contacts/create', 'Admin\Contacts::create');
    $routes->post('contacts', 'Admin\Contacts::store');
    $routes->get('contacts/(:num)/edit', 'Admin\Contacts::edit/$1');
    $routes->post('contacts/(:num)', 'Admin\Contacts::update/$1');
    $routes->post('contacts/(:num)/delete', 'Admin\Contacts::delete/$1');

    $routes->get('settings', 'Admin\Settings::index');
    $routes->post('settings', 'Admin\Settings::update');
});
