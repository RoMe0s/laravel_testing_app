<?php

use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * @var Router $router
 */

$router->group(['middleware' => 'auth'], function (Router $router) {
    $router->group(['prefix' => 'references'], function (Router $router) {
        $router->get('/', 'ReferenceController@index');
        $router->post('filter', 'ReferenceController@filter');
    });

    $router->group(['prefix' => 'temp-insurances'], function (Router $router) {
        $router->get('/', 'TempInsuranceController@index');
        $router->post('/', 'TempInsuranceController@store');
        $router->post('/update-picture', 'TempInsuranceController@updatePicture');
    });

    $router->apiResource('insurances', 'InsuranceController')->only(['store']);

    $router->group(['prefix' => 'references'], function (Router $router) {
        $router->get('/', 'ReferenceController@index');
        $router->post('/filter', 'ReferenceController@filter');
    });
});

