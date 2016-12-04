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
        // Change background artist in the footer
        document.getElementById('background-artist').innerHTML = '<a href="http://www.publicdomainpictures.net/view-image.php?image=28562&picture=christmas-bulbs-red-background">Debi Geroux - Public Domain</a>';

        if(getCookie('snoweffect') === 'false') {
            document.getElementsByTagName('body')[0].innerHTML += '<a class="disableSnowLink" href="#" onclick="enableSnowEffect()">Enable snow effect</a>';
            return;
        }

        // Add a link to disable the effect
        document.getElementsByTagName('body')[0].innerHTML += '<a class="disableSnowLink" href="#" onclick="disableSnowEffect()">Disable snow effect</a>';

        // Add the snow effect
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
    });
}

function disableSnowEffect() {
    setCookie('snoweffect', 'false', 30);
    location.reload();
}

function enableSnowEffect() {
    setCookie('snoweffect', 'true', 30);
    location.reload();
}

function setCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
