@php

$features = $devcycle_client->allFeatures($devcycle_user_data);
$variation_name = $features["hello-togglebot"] ? $features["hello-togglebot"]["variationName"] : "Default";

$speed = $openfeature_client->getStringValue( "togglebot-speed", "off", $openfeature_context);
$wink = $openfeature_client->getBooleanValue("togglebot-wink", false, $openfeature_context);

switch ($speed) {
case 'slow':
$message = 'Awesome, look at you go!';
break;
case 'fast':
$message = 'This is fun!';
break;
case 'off-axis':
$message = '...I\'m gonna be sick...';
break;
case 'surprise':
$message = 'What the unicorn?';
break;
default:
$message = 'Hello! Nice to meet you.';
break;
}

$togglebot_src = $wink ? '/img/togglebot-wink.png' : '/img/togglebot.png';
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
