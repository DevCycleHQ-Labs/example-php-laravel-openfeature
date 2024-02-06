<?php

use Illuminate\Support\Facades\Route;
use DevCycle\DevCycleConfiguration;
use DevCycle\Api\DevCycleClient;
use DevCycle\Model\DevCycleOptions;
use DevCycle\Model\DevCycleUser;
use GuzzleHttp\Client as GuzzleClient;
use OpenFeature\implementation\flags\EvaluationContext;
use OpenFeature\OpenFeatureAPI;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    $options = new DevCycleOptions(true);

    $devcycle_client = new DevCycleClient(
        sdkKey: getenv("DEVCYCLE_SERVER_SDK_KEY"),
        dvcOptions: $options
    );

    $api = OpenFeatureAPI::getInstance();

    $api->setProvider($devcycle_client->getOpenFeatureProvider());

    $openfeature_client = $api->getClient();

    $devcycle_user_data = new DevCycleUser(array(
        "user_id" => "my-user"
    ));

    $openfeature_context = new EvaluationContext('devcycle_user_data');

    return view('welcome', compact('devcycle_client', 'devcycle_user_data', 'openfeature_client', 'openfeature_context'));
});
