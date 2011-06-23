/*! Respond.js: min/max-width media query polyfill. (c) Scott Jehl. MIT Lic. j.mp/respondjs  */
(function( win, mqSupported ){
	//exposed namespace
	win.respond		= {};
	
	//define update even in native-mq-supporting browsers, to avoid errors
	respond.update	= function(){};
	
	//expose media query support flag for external use
	respond.mediaQueriesSupported	= mqSupported;
	
	//if media queries are supported, exit here
	if( mqSupported ){ return; }
	
	//define vars
	var doc 			= win.document,
		docElem 		= doc.documentElement,
		mediastyles		= [],
		rules			= [],
		appendedEls 	= [],
		parsedSheets 	= {},
		resizeThrottle	= 30,
		head 			= doc.getElementsByTagName( "head" )[0] || docElem,
		links			= head.getElementsByTagName( "link" ),
		requestQueue	= [],
		
		//loop stylesheets, send text content to translate
		ripCSS			= function(){
			var sheets 	= links,
				sl 		= sheets.length,
				i		= 0,
				//vars for loop:
				sheet, href, media, isCSS;

			for( ; i < sl; i++ ){
				sheet	= sheets[ i ],
				href	= sheet.href,
				media	= sheet.media,
				isCSS	= sheet.rel && sheet.rel.toLowerCase() === "stylesheet";

				//only links plz and prevent re-parsing
				if( !!href && isCSS && !parsedSheets[ href ] ){
					if( !/^([a-zA-Z]+?:(\/\/)?(www\.)?)/.test( href ) 
						|| href.replace( RegExp.$1, "" ).split( "/" )[0] === win.location.host ){
						requestQueue.push( {
							href: href,
							media: media
						} );
					}
					else{
						parsedSheets[ href ] = true;
					}	
				}
			}
			makeRequests();
				
		},
		
		//recurse through request queue, get css text
		makeRequests	= function(){
			if( requestQueue.length ){
				var thisRequest = requestQueue.shift();
				
				ajax( thisRequest.href, function( styles ){
					translate( styles, thisRequest.href, thisRequest.media );
					parsedSheets[ thisRequest.href ] = true;
					makeRequests();
				} );
			}
		},
		
		//find media blocks in css text, convert to style blocks
		translate			= function( styles, href, media ){
			var qs			= styles.match(  /@media[^\{]+\{([^\{\}]+\{[^\}\{]+\})+/gi ),
				ql			= qs && qs.length || 0,
				//try to get CSS path
				href		= href.substring( 0, href.lastIndexOf( "/" )),
				repUrls		= function( css ){
					return css.replace( /(url\()['"]?([^\/\)'"][^:\)'"]+)['"]?(\))/g, "$1" + href + "$2$3" );
				},
				useMedia	= !ql && media,
				//vars used in loop
				i			= 0,
				j, fullq, thisq, eachq, eql;

			//if path exists, tack on trailing slash
			if( href.length ){ href += "/"; }	
				
			//if no internal queries exist, but media attr does, use that	
			//note: this currently lacks support for situations where a media attr is specified on a link AND
				//its associated stylesheet has internal CSS media queries.
				//In those cases, the media attribute will currently be ignored.
			if( useMedia ){
				ql = 1;
			}
			

			for( ; i < ql; i++ ){
				j	= 0;
				
				//media attr
				if( useMedia ){
					fullq = media;
					rules.push( repUrls( styles ) );
				}
				//parse for styles
				else{
					fullq	= qs[ i ].match( /@media ([^\{]+)\{([\S\s]+?)$/ ) && RegExp.$1;
					rules.push( RegExp.$2 && repUrls( RegExp.$2 ) );
				}
				
				eachq	= fullq.split( "," );
				eql		= eachq.length;
				
					
				for( ; j < eql; j++ ){
					thisq	= eachq[ j ];
					mediastyles.push( { 
						media	: thisq.match( /(only\s+)?([a-zA-Z]+)(\sand)?/ ) && RegExp.$2,
						rules	: rules.length - 1,
						minw	: thisq.match( /\(min\-width:[\s]*([\s]*[0-9]+)px[\s]*\)/ ) && parseFloat( RegExp.$1 ), 
						maxw	: thisq.match( /\(max\-width:[\s]*([\s]*[0-9]+)px[\s]*\)/ ) && parseFloat( RegExp.$1 )
					} );
				}	
			}

			applyMedia();
		},
        	
		lastCall,
		
		resizeDefer,
		
		//enable/disable styles
		applyMedia			= function( fromResize ){
			var name		= "clientWidth",
				docElemProp	= docElem[ name ],
				currWidth 	= doc.compatMode === "CSS1Compat" && docElemProp || doc.body[ name ] || docElemProp,
				styleBlocks	= {},
				dFrag		= doc.createDocumentFragment(),
				lastLink	= links[ links.length-1 ],
				now 		= (new Date()).getTime();
			
			//throttle resize calls	
			if( fromResize && lastCall && now - lastCall < resizeThrottle ){
				clearTimeout( resizeDefer );
				resizeDefer = setTimeout( applyMedia, resizeThrottle );
				return;
			}
			else {
				lastCall	= now;
			}
										
			for( var i in mediastyles ){
				var thisstyle = mediastyles[ i ];
				if( !thisstyle.minw && !thisstyle.maxw || 
					( !thisstyle.minw || thisstyle.minw && currWidth >= thisstyle.minw ) && 
					(!thisstyle.maxw || thisstyle.maxw && currWidth <= thisstyle.maxw ) ){						
						if( !styleBlocks[ thisstyle.media ] ){
							styleBlocks[ thisstyle.media ] = [];
						}
						styleBlocks[ thisstyle.media ].push( rules[ thisstyle.rules ] );
				}
			}
			
			//remove any existing respond style element(s)
			for( var i in appendedEls ){
				if( appendedEls[ i ] && appendedEls[ i ].parentNode === head ){
					head.removeChild( appendedEls[ i ] );
				}
			}
			
			//inject active styles, grouped by media type
			for( var i in styleBlocks ){
				var ss		= doc.createElement( "style" ),
					css		= styleBlocks[ i ].join( "\n" );
				
				ss.type = "text/css";	
				ss.media	= i;
				
				if ( ss.styleSheet ){ 
		        	ss.styleSheet.cssText = css;
		        } 
		        else {
					ss.appendChild( doc.createTextNode( css ) );
		        }
		        dFrag.appendChild( ss );
				appendedEls.push( ss );
			}
			
			//append to DOM at once
			head.insertBefore( dFrag, lastLink.nextSibling );
		},
		//tweaked Ajax functions from Quirksmode
		ajax = function( url, callback ) {
			var req = xmlHttp();
			if (!req){
				return;
			}	
			req.open( "GET", url, true );
			req.onreadystatechange = function () {
				if ( req.readyState != 4 || req.status != 200 && req.status != 304 ){
					return;
				}
				callback( req.responseText );
			}
			if ( req.readyState == 4 ){
				return;
			}
			req.send();
		},
		//define ajax obj 
		xmlHttp = (function() {
			var xmlhttpmethod = false,
				attempts = [
					function(){ return new ActiveXObject("Microsoft.XMLHTTP") },
					function(){ return new XMLHttpRequest() }		
				],
				al = attempts.length;
		
			while( al-- ){
				try {
					xmlhttpmethod = attempts[ al ]();
				}
				catch(e) {
					continue;
				}
				break;
			}
			return function(){
				return xmlhttpmethod;
			};
		})();
	
	//translate CSS
	ripCSS();
	
	//expose update for re-running respond later on
	respond.update = ripCSS;
	
	//adjust on resize
	function callMedia(){
		applyMedia( true );
	}
	if( win.addEventListener ){
		win.addEventListener( "resize", callMedia, false );
	}
	else if( win.attachEvent ){
		win.attachEvent( "onresize", callMedia );
	}
})(
	this,
	(function( win ){
		
		//for speed, flag browsers with window.matchMedia support and IE 9 as supported
		if( win.matchMedia ){ return true; }

		var bool,
			doc			= document,
			docElem		= doc.documentElement,
			refNode		= docElem.firstElementChild || docElem.firstChild,
			// fakeBody required for <FF4 when executed in <head>
			fakeUsed	= !doc.body,
			fakeBody	= doc.body || doc.createElement( "body" ),
			div			= doc.createElement( "div" ),
			q			= "only all";
			
		div.id = "mq-test-1";
		div.style.cssText = "position:absolute;top:-99em";
		fakeBody.appendChild( div );
		
		div.innerHTML = '_<style media="'+q+'"> #mq-test-1 { width: 9px; }</style>';
		if( fakeUsed ){
			docElem.insertBefore( fakeBody, refNode );
		}	
		div.removeChild( div.firstChild );
		bool = div.offsetWidth == 9;  
		if( fakeUsed ){
			docElem.removeChild( fakeBody );
		}	
		else{
			fakeBody.removeChild( div );
		}
		return bool;
	})( this )
);