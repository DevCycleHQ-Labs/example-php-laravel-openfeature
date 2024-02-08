<?php

use Illuminate\Support\Facades\Route;
use DevCycle\Api\DevCycleClient;
use DevCycle\Model\DevCycleOptions;
use DevCycle\Model\DevCycleUser;
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

    // Create a new DevCycleOptions object, enabling debug mode or additional logging if true is passed.
    $options = new DevCycleOptions(true);


    // Initialize the DevCycle client with the server SDK key obtained from environment variables and the previously defined options.
    // This client will interact with the DevCycle API for feature flag evaluations.
    $devcycle_client = new DevCycleClient(
        sdkKey: getenv("DEVCYCLE_SERVER_SDK_KEY"),
        dvcOptions: $options
    );

    // Obtain an instance of the OpenFeature API. This is a singleton instance used across the application.
    $api = OpenFeatureAPI::getInstance();


    // Set the feature flag provider for OpenFeature to be the provider obtained from the DevCycle client.
    // This integrates DevCycle with OpenFeature, allowing OpenFeature to use DevCycle for flag evaluations.
    $api->setProvider($devcycle_client->getOpenFeatureProvider());

    // Retrieve the OpenFeature client from the API instance. This client can be used to evaluate feature flags using the OpenFeature API.
    $openfeature_client = $api->getClient();

    // Create a new DevCycleUser object with the specified user ID. This object represents a user for whom feature flags will be evaluated.
    $devcycle_user_data = new DevCycleUser(array(
        "user_id" => "my-user"
    ));

    // Instantiate a new EvaluationContext object with 'devcycle_user_data' as its parameter. However, this seems to be a misuse or a typo,
    // as typically, the EvaluationContext should be instantiated with an array or similar structure representing the context, not a string.
    // If 'devcycle_user_data' is intended to be used as context, it should be passed directly as an object or its data extracted into an array,
    // not passed as a string literal.
    $openfeature_context = new EvaluationContext('devcycle_user_data');

    return view('welcome', compact('devcycle_client', 'devcycle_user_data', 'openfeature_client', 'openfeature_context'));
});
