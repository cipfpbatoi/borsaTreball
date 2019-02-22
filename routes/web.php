<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api'], function ($router) {
    $router->get('/menu', 'MenuController@index');
    
    $router->get('/users','UserController@index');
    $router->get('/users/{id}','UserController@show');
    $router->post('/users','UserController@store');
    $router->put('/users/{id}','UserController@update');
    $router->delete('/users','UserController@destroy');
    
    $router->get('/ciclos','CicloController@index');
    $router->get('/ciclos/{id}','CicloController@show');
    $router->post('/ciclos','CicloController@store');
    $router->put('/ciclos/{id}','CicloController@update');
    $router->delete('/ciclos','CicloController@destroy');
    
    $router->get('/alumnes','AlumneController@index');
    $router->get('/alumnes/{id}','AlumneController@show');
    $router->post('/alumnes','AlumneController@store');
    $router->put('/alumnes/{id}','AlumneController@update');
    $router->delete('/alumnes','AlumneController@destroy');
    
    $router->get('/empresas','EmpresaController@index');
    $router->get('/empresas/{id}','EmpresaController@show');
    $router->post('/empresas','EmpresaController@store');
    $router->put('/empresas/{id}','EmpresaController@update');
    $router->delete('/empresas','EmpresaController@destroy');
    
    $router->get('/ofertas','OfertaController@index');
    $router->get('/ofertas/{id}','OfertaController@show');
    $router->post('/ofertas','OfertaController@store');
    $router->put('/ofertas/{id}','OfertaController@update');
    $router->delete('/ofertas','OfertaController@destroy');
    
    $router->get('/responsables','ResponsableController@index');
    $router->get('/responsables/{id}','ResponsableController@show');
    $router->post('/responsables','ResponsableController@store');
    $router->put('/responsables/{id}','ResponsableController@update');
    $router->delete('/responsables','ResponsableController@destroy'); 
    
    
});

$router->get('/{route:.*}/', function ()  {
    return view('app');
});
