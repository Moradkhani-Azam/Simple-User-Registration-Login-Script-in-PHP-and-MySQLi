<?php

$routes = [
    ['GET', '/', 'HomeController@index'],
    ['POST', '/register', 'HomeController@register'],
    ['GET', '/loginPage', 'HomeController@loginPage'],
    ['POST', '/login', 'HomeController@login'],
    ['GET', '/logout', 'HomeController@logout'],
    ['GET', '/admin/links/index', 'AdminController@index'],
    ['GET', '/admin/links/create', 'AdminController@create'],
    ['POST', '/admin/links/store', 'AdminController@store'],
    ['GET', '/admin/links/edit', 'AdminController@edit'],
    ['POST', '/admin/links/update', 'AdminController@update'],
    ['POST', '/admin/links/destroy', 'AdminController@destroy']
];