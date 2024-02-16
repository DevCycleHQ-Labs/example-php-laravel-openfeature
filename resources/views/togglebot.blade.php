@php

// Fetch all feature flags for the specified DevCycle user. The result is an associative array where keys are feature flag keys and values are their details.
$features = $devcycle_client->allFeatures($devcycle_user_data);

// Determine the variation name for the "hello-togglebot" feature flag. If the flag is present, use its variation name; otherwise, default to "Default".
$variation_name = $features["hello-togglebot"] ? $features["hello-togglebot"]["variationName"] : "Default";


// Use the OpenFeature client to get the string value of the "togglebot-speed" feature flag. If the flag is not set, default to "off".
// The evaluation context (user or environment details) is passed to refine the flag evaluation.
$speed = $openfeature_client->getStringValue( "togglebot-speed", "off", $openfeature_context);

// Use the OpenFeature client to get the boolean value of the "togglebot-wink" feature flag. If the flag is not set, default to false.
$wink = $openfeature_client->getBooleanValue("togglebot-wink", false, $openfeature_context);


// Based on the value of the "togglebot-speed" feature flag, set a corresponding message.
switch ($speed) {
case 'slow': // If the speed is set to "slow", set a specific message.
$message = 'Awesome, look at you go!';
break;
case 'fast': // If the speed is set to "fast", set a different message.
$message = 'This is fun!';
break;
case 'off-axis': // If the speed is set to "off-axis", set a message indicating discomfort.
$message = '...I\'m gonna be sick...';
break;
case 'surprise': // If the speed is set to "surprise", set a surprising message.
$message = 'What the unicorn?';
break;
default: // For any other value (including "off"), set a default greeting message.
$message = 'Hello! Nice to meet you.';
break;
}

// Determine the source of the togglebot image. If the "togglebot-wink" flag is true, use the winking image; otherwise, use the default image.
$togglebot_src = $wink ? '/img/togglebot-wink.png' : '/img/togglebot.png';

// If the speed feature flag is set to "surprise", override the togglebot image source with a unicorn image.
if ($speed === 'surprise') {
$togglebot_src = '/img/unicorn.svg';
}


@endphp

<div class="App-content">
    <div class="ToggleBot-message">
        "{{$message}}"
    </div>
    <img src="{{ $togglebot_src }}" class="ToggleBot-logo spin-{{$speed}}" alt="togglebot" />
    <div class="ToggleBot-variation">
        Serving Variation: <b>"{{$variation_name}}"</b>
    </div>
</div>
