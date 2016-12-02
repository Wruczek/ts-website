// Remember: This file is loaded before jQuery!

// Check if the current month on user device is December...
if (new Date().getMonth() === 11) {
    // Enable the christmas functions! Happy holidays from Wruczek! :D

    // Load and enable the christmas theme
    var stylesheet = document.createElement('link');
    stylesheet.href = 'css/christmas-theme.css';
    stylesheet.rel = 'stylesheet';
    document.head.appendChild(stylesheet);

    // Load and enable the snow
    var script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/JQuery-Snowfall/1.7.4/snowfall.jquery.min.js';
    document.head.appendChild(script);

    // Wait for the snowfall script and jQuery to load
    window.addEventListener('load', function () {
        defer(proceedWithJquery);
    });
}

function defer(method) {
    if (window.jQuery)
        method();
    else
        setTimeout(function() { defer(method) }, 50);
}

function proceedWithJquery() {
    $(document).snowfall({
        flakeCount: ($(document).width() > 992 ? 500 : 100),
        flakeIndex: -1,
        minSize: 4,
        maxSize: 5,
        minSpeed: 1,
        maxSpeed: 2,
        round: true,
        shadow: true
    });

    // Change background artist in the footer
    $('#background-artist').html('<a href="http://www.publicdomainpictures.net/view-image.php?image=28562&picture=christmas-bulbs-red-background">Debi Geroux - Public Domain</a>');
}
