<?php

use Illuminate\Support\Facades\Route;
use DevCycle\Api\DevCycleClient;
use DevCycle\Model\DevCycleOptions;
use DevCycle\Model\DevCycleUser;
use OpenFeature\implementation\flags\Attributes;
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

    // Create a new user attribute object that cand be used by OpenFeature as part of the flag evaluation process.
    $user_attributes = new Attributes(array("user_id" => "my-user"));

    // Create a new evaluation context for the feature flag evaluations. This context is used to provide user or environment details for flag evaluations in OpenFeature.
    $openfeature_context = new EvaluationContext(attributes: $user_attributes);

    // Create a user object that can be used by the DevCycle client for feature flag evaluations.
    $devcycle_user_data = DevCycleUser::FromEvaluationContext($openfeature_context);

    return view('welcome', compact('devcycle_client', 'devcycle_user_data', 'openfeature_client', 'openfeature_context'));
});
