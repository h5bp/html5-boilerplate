/**
 *
 * Plugin:
 * @version 1.0
 *
 * @author: Joris DANIEL
 * @fileoverview: Easy way to load social API properly in your Javascript
 * Twitter, Pinterest, Youtube, Facebook, GooglePlus
 *
 * Copyright (c) 2013 Joris DANIEL
 * Licensed under the MIT license
 *
**/

(function( win, doc ){

    'use strict';

    var socialAPI           = win.socialAPI || {},
        body                = doc.getElementsByTagName('body')[0];

    //Load script in asynchrone mode
    socialAPI.async         = true;

    //Manage API to load and params
    socialAPI.load = {

        twitter: function(){

            //Append the SDK in the DOM
            this.append('//platform.twitter.com/widgets.js', 'twitter-wjs');

        },

        pinterest: function(){

            //Append the SDK in the DOM
            this.append('//assets.pinterest.com/js/pinit.js');

        },

        youtube: function(){

            //Append the SDK in the DOM
            this.append('//youtube.com/player_api');

        },

        facebook: function( locale ){

            var defaultLanguage = 'fr_FR',
                localeSDK = ( typeof locale != 'undefined' ) ? locale : defaultLanguage,
                tag;

            //If Facebook SDK already exist
            if( doc.getElementById('facebook-jssdk') ) {return;}

            //Add fb-root tag
            tag = document.createElement('div');
            tag.id = 'fb-root';
            doc.getElementsByTagName('body')[0].appendChild( tag );

            //Append the SDK in the DOM with locale
            // #xfbml = 1 : the SDK will parse the DOM to find and initialize social plugins
            //status = 0 : Improve page load and the SDK no get information about the current user on page load
            //More information : https://developers.facebook.com/docs/javascript/gettingstarted/
            this.append('//connect.facebook.net/' + localeSDK + '/all.js#xfbml=1&status=0', 'facebook-jssdk');

        },

        googlePlus: function( locale ){

            var defaultLanguage = 'fr',
                localeSDK = ( typeof locale != 'undefined' ) ? locale : defaultLanguage;

            //Change the locale
            win.___gcfg = { lang: localeSDK };

            //Append the SDK in the DOM
            this.append('//apis.google.com/js/plusone.js');

        },

        append: function( url, id ){

            var tag;

            tag = doc.createElement('script');
            tag.async = socialAPI.async;
            if( typeof id != 'undefined' ){
                tag.id = id;
            }
            tag.type = 'text/javascript';
            tag.src = url;
            body.appendChild( tag );

        }

    }

    win.socialAPI = socialAPI;

})( window, document )
