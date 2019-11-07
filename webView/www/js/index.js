var WINDOW_URL = "https://www.marca.com";
var window_location = "_blank";
var window_options = "location=no,hideurlbar=yes,hidenavigationbuttons=yes,footer=no";

var referenceToWebView;
var tokenFirebaseId;

/**
 * Aplicacion que maneja cordova
 */
var app = {

    /**
     * Nos suscribimos al evento de OnDeviceReady
     */
    initialize: function() {
        document.addEventListener('deviceready', this.onDeviceReady.bind(this), false);
    },

    /**
     * Cuando esta cargado el dispositivo iniciamos el webView
     */
    onDeviceReady: function() {


        window.FirebasePlugin.subscribe("AllUsers");

        referenceToWebView = cordova.InAppBrowser.open(WINDOW_URL, window_location, window_options);

        referenceToWebView.addEventListener("loadstop", function() {

            window.FirebasePlugin.getToken(function(token) {

                if (tokenFirebaseId === undefined) {

                    tokenFirebaseId = token;

                    referenceToWebView.executeScript({
                        code: "window.localStorage.setItem('tokenFirebaseId', '" + tokenFirebaseId + "'); alert(localStorage.getItem('tokenFirebaseId'));"
                    });

                }

            }, function(error) {
                console.error(error);
            });


        });

        referenceToWebView.addEventListener("exit", this.onCloseWebView.bind(this));

    },


    /**
     * Cuando cerramos la ventana, tambien se cierra la aplicacion
     */
    onCloseWebView: function() {
        navigator.app.exitApp();
    }
};

app.initialize();