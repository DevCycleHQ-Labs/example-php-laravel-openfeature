@php

// Retrieve the value of the "example-text" feature flag using the OpenFeature client.
// The default value is "default" if the flag is not set or cannot be fetched.
$step = $openfeature_client->getStringValue("example-text", "default", $openfeature_context);


// Based on the value of the "example-text" feature flag, adjust the content of the header and body variables accordingly.
switch ($step) {
case "step-1": // If the flag's value is "step-1", set the header and body for the first step in the onboarding process.
$header = "Welcome to DevCycle's example app.";
$body = "If you got here through the onboarding flow, just follow the instructions to change and create new Variations and see how the app reacts to new Variable values.";
break;
case "step-2": // If the flag's value is "step-2", provide information relevant to the second step in the onboarding.
$header = "Great! You've taken the first step in exploring DevCycle.";
$body = "You've successfully toggled your very first Variation. You are now serving a different value to your users and you can see how the example app has reacted to this change. Next, go ahead and create a whole new Variation to see what else is possible in this app.";
break;
case "step-3": // If the flag's value is "step-3", congratulate the user on progressing and encourage further exploration.
$header = "You're getting the hang of things.";
$body = "By creating a new Variation with new Variable values and toggling it on for all users, you've already explored the fundamental concepts within DevCycle. There's still so much more to the platform, so go ahead and complete the onboarding flow and play around with the feature that controls this example in your dashboard.";
break;
default: // For any other value, provide a default welcome message and guidance for newcomers.
$header = "Welcome to DevCycle's example app.";
$body = "If you got to the example app on your own, follow our README guide to create the Feature and Variables you need to control this app in DevCycle.";
}

// The resulting $header and $body variables contain text that can be dynamically inserted into the webpage or app view,
// allowing the content to adapt based on the progression of the user through the onboarding process or their interaction with the example application.


@endphp

<div class="App-description">
    <div>
        <h3>{{$header }}</h3>
        <p>{{ $body }}</p>
    </div>
</div>
