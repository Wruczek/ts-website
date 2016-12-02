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
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/JQuery-Snowfall/1.7.4/snowfall.min.js';
    document.head.appendChild(script);

    window.addEventListener('load', function () {
        snowFall.snow(document.body, {
            flakeCount: (document.body.clientWidth > 992 ? 500 : 100),
            flakeIndex: -1,
            minSize: 4,
            maxSize: 5,
            minSpeed: 1,
            maxSpeed: 2,
            round: true,
            shadow: true
        });

        // Change background artist in the footer
        document.getElementById('background-artist').innerHTML = '<a href="http://www.publicdomainpictures.net/view-image.php?image=28562&picture=christmas-bulbs-red-background">Debi Geroux - Public Domain</a>';
    });
}
