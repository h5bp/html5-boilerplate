#  HTML5 Boilerplate [http://html5boilerplate.com](http://html5boilerplate.com)

## Changelog:

### v.1.0 : March 21st, 2011

#### Build Script
<ul>
	<li>Files linked via @import will be inlined into the files they are imported to using Corey Hart's CSS Compressor.</li>
	<li>Environments are definable.</li>
	<li>htaccess Expires headers are upgraded to 1year, as the filenames are revved</li>
	<li>Massive rewrite so you can define which HTML, CSS, JS files to operate on in your configurable project.properties files. This allows you to let the build script operate on very unique folder architecture, including non-H5BP projects.</li>
	<li>Added a source directory option in the build config, so your source files can be in a different directory from the final generated files (useful for other CMSes/frameworks like Django). </li>		
</ul>

#### index.html
<ul>
	<li>We use a <a href="http://paulirish.com/2010/the-protocol-relative-url/">protocol-relative url</a> for the jQuery include, to prevent the mixed content warning.</li>
	<li>The order of <code>&lt;meta></code> tags, <code>&lt;title></code>, and charset has been <a href="https://github.com/paulirish/html5-boilerplate/wiki/The-markup">documented more extensively now</a>. TL;DR: You are <a href="https://github.com/paulirish/html5-boilerplate/commit/4b67ea5cabb8c2b75faf2e255344cdffdf190464">safe to use the boilerplate's order of tags</a>.</li>
	<li>We've shortened up the Google Analytics snippet.</li>
	<li>Added an ARIA <code>role</code> attribute to <code>div#main</code>. This assumes your main content goes within that container.</li>
	<li>IE9 doesn't get it's own conditional class! Yay!</li>		
</ul>

#### style.css
<ul>
	<li>Added <code>.focusable</code> helper class that extends <code>.visuallyhidden</code> to allow the element to be focusable when navigated to via the keyboard.</li>
	<li>Anchor links are no longer reset. Basically our reset is the effectively merged with Eric Meyer's recent CSS reset update and also the HTML5 Doctor reset.</li>
	<li>An unordered list within a nav element will no longer have a margin.</li>
	<li>All helper classes are now after primary styles to ensure correct overrides and not be burdened with resets. </li>
	<li><code>.visuallyhidden</code> is no longer camelCase, as to be consistent with other classname formats.</li>
	<li>Updated the specificity of <code>.visuallyhidden</code> rule to make sure it overrides all other declarations. </li>
	<li>Removed reset on image elements within table cells as they look ugly alongside multiline texts. Browsers default to baseline alignment for images which works better than top alignment.</li>
	<li>Increased margin-left on ol, to allow for 2-digit list numbers.</li>
	<li>Added a print reset on IE's proprietary filters.</li>
	<li>Print styles no longer prints hash links or javascript links.</li>
	<li>Updated sub/sup css to make them not be impacted by line-height, so now you can do sub/superscripts without worrying.</li>		
</ul>

#### Project
<ul>
	<li>Added a <a href="http://humanstxt.org">humans.txt</a> so you can clarify authorship and tools used</li>
	<li>Removed YUI profiling. You probably weren't using it anyway.</li>
	<li>Removed QUnit's unit tests. There is no need to ship with them, really.</li>		
</ul>

#### Webserver Configs
#### .htaccess
<ul>
	<li>.htaccess is far more documented now. Take a read through it!</li>
	<li><a href="https://github.com/paulirish/html5-boilerplate/commit/37b5fec090d00f38de64b591bcddcb205aadf8ee">Changed mimetype of .ico files to "image/x-icon"</a>.</li>
	<li>HTML Manifest files now use <code>.appcache</code> extension instead of <code>.manifest</code>, as per <a href="http://html5.org/r/5812">http://html5.org/r/5812</a>.</li>
	<li>Force deflate for accept-encoding headers mangled by turtle tappers, courtesy of <a href="http://developer.yahoo.com/blogs/ydn/posts/2010/12/pushing-beyond-gzipping/">Yahoo!'s research</a></li>
	<li>We nerfed some of the directives in case you're on server without <code>mod_headers</code>. (Which is totally crazy, man)</li>
	<li>Block access to .git and .svn folders.</li>
	<li>Eradicating Chrome's console warning on WOFF font downloads.</li>
	<li>More optimizations available if you set the .htaccess details up in your httpd.conf</li>
	<li>.htaccess now caches .htc files</li>
  
	<li>Moved all server configurations (except apache's .htaccess) over to <a href ="https://github.com/paulirish/html5-boilerplate-server-configs">the new html5-boilerplate-server-configs repo</a>. Head over there if you are not using Apache. </li>
	
	<li>Updated <code>.htaccess</code> and <code>mime.types</code> for ogg formats.</li>
	<li>Fixed regression where EOT fonts had been excluded from DEFLATE compression</li>
	<li>Apache version independence: Use <code>mod_filter</code> for compression, with fallback to AddOutputFilterByType directive for legacy versions</li>
	<li>Added plugin/extension mime types for Safari, Chrome, Firefox</li>
</ul>
#### nginx
<ul>
	<li>Cleaned up cache expires directives.</li>
	<li>Now includes SVG and font formats for gzipping.</li>
	<li>expires header bug fixed.</li>
</ul>
#### IIS
<ul>
	<li>Added Flash video mime types to IIS server</li>
	<li>Fixed some mimetype weirdness that was preventing proper caching</li>
</ul>

<ul>
	<li>Also Google App Engine, Lighttpd, and NodeJS <a href="https://github.com/paulirish/html5-boilerplate-server-configs">configurations were added</a></li>
</ul>

<p>Basically a lot of great updates were made for 1.0. <a href="https://github.com/paulirish/html5-boilerplate/compare/v0.9.5...v1.0">Here are all 220 commits since last release.</a>. You may ask though, <a href="http://html5boilerplate.com/docs/#FAQs★do-i-need-to-upgrade-my-sites-to-a-new-version">do I need to upgrade existing sites</a>? Short answer: nah, you're good.</p>

#### Contributors
[Mickael Daniel](http://blog.mklog.fr/), Dave Kirk, [Jonathan Verrecchia](http://www.html5-css3.fr/), [nlogax](https://github.com/nlogax), [Rob Larsen](http://htmlcssjavascript.com/), 
[David Murdoch](http://www.vervestudios.co/), [AD7six](http://www.ad7six.com/), 
[Mathias Bynens](http://mathiasbynens.be/), [Michael van Laar](http://www.michael-van-laar.de/), [Mike West](http://mikewest.org/), [Mikko Tikkanen](http://www.mintusability.com/), [Velir](http://velir.com/), [Stephen Gariepy](http://garowetz.ca/)

##### Boilerplate 
[Adam J. McIntyre](http://www.amodernfable.com/), [Adeel Ejaz](http://adeelejaz.com/), akolesnikov, [Alex Dunae](http://dialect.ca/), [Andrew Le](http://andrewdle.com/), [ashnur](https://github.com/ashnur), [Ben Truyman](http://bentruyman.com/), [Bruno Aguirre](http://brunoaguirre.com/), [Chris Hager](http://metachris.org/), [Corey Ward](http://blog.coreyward.net/), [Craig Barnes](https://github.com/craigbarnes), crappish, [Daniel Schildt](http://autiomaa.org/), [Dave DeSandro](https://github.com/daveatnclud), [Dustin Whittle](http://dustinwhittle.com/), grigio, [Irakli Nadareishvili](http://freshblurbs.com/), [Jaime Bueza](http://jaime.bueza.com/), [Jake Ingman](https://github.com/jingman), [James A. Rosen](http://jamesarosen.com/), [Jeremy Balch](https://github.com/balchjd), [joe bartlett](http://twitter.com/jdbartlett), [Joe Sak](http://www.joesak.com/), [John Bacon](https://github.com/johnbacon)
[Jonathan Fielding](https://github.com/jonathan-fielding), [Jonathan Neal](http://iecss.com/), [kblomqvist](https://github.com/kblomqvist), [Kenneth Nordahl](http://nordahl.me/), [Maarten Verbaarschot](https://github.com/mverbaar), [Manuel Strehl](http://www.manuel-strehl.de/), [Marcel Turi](http://marcel.turi.co/), [Martin Hintzmann](https://github.com/Hintzmann), [mikealmond](https://github.com/mikealmond)
[mikkotikkanen](http://www.mintusability.com/), [Nic Pottier](https://github.com/nicpottier), [Paul Neave](http://www.neave.com/), [Peter Beverloo](http://peter.sh/), [Rick Waldron](http://weblog.bocoup.com/), [Rob Flaherty](http://www.ravelrumba.com/), [S Anand](http://www.s-anand.net/), [Sam Sherlock](http://samsherlock.com/), [Michael Cetrulo](http://www.linkedin.com/in/web2samus), [simshaun](https://github.com/simshaun), [Sirupsen](http://sirupsen.com/), [Stephen Gariepy](http://garowetz.ca/), [timemachine3030 ](https://github.com/timemachine3030), [Vinay](http://www.artminister.com/), [Weston Ruter](http://weston.ruter.net/), [WraithKenny](http://unfocus.com/), [Yann Mainier](http://yann.mainier.com/), [Michael van Laar](http://www.michael-van-laar.de/), [Massimo Lombardo](http://unwiredbrain.com/), [Ivan Nikolić ](http://twitter.com/niksy), [Kaelig](http://kaelig.fr/), [Richard Bradshaw](http://bradshawenterprises.com/), [SammyK](http://sammyk.me/), [alrra](https://github.com/alrra), [Rizky Syazuli](http://id.linkedin.com/in/rizky), [iszak](https://github.com/Iszak), [aaron peters](https://github.com/aaronpeters), [Swaroop C H](http://www.swaroopch.com/), [Mike Połtyn](http://mike.poltyn.com/), Marco d'Itri, Mike Lamb , [BIG Folio](http://bigfolio.com/), Philip von Bargen, Meander, Daniel Harttman, rse, timwillison, ken nordahl, [Erik Dahlström](http://my.opera.com/macdev_ed), christopherjacob, [Chew Choon Keat](http://blog.choonkeat.com/), benalman, stoyan, Markus, [Vladimir Carrer](http://www.vcarrer.com/), [aristidesfl](https://github.com/aristidesfl), [Trevor Norris](http://blog.trevorjnorris.com/) 



#####Configs
[Dusan Hlavaty](http://sk.linkedin.com/in/dusanhlavaty), [Sean Caetano Martin](http://www.xonecas.com/), [yaph](http://www.ramiro.org/), [michaud](https://github.com/michaud), Paul Sarena, [Graham Weldon](http://grahamweldon.com/), [Ron. Adams](http://visual-assault.org/)

#####Translators
[alrra](http://twitter.com/alrra), [Anton Kovalyov](http://self.kovalyov.net/), [Milos Gavrilovic](http://www.arvag.net/), [jorge-vitrubio](https://github.com/jorge-vitrubio), Julian Wachholz, [laviperchik](https://github.com/laviperchik), [lenzcom](https://github.com/lenzcom), [Mathias Bynens](http://mathiasbynens.be/), [Mickael Daniel](http://blog.mklog.fr/), [Mike West](http://mikewest.org/), [Niels Bom](http://www.nielsbom.com/), Ricardo Tomasi, [skill83 ](https://github.com/skill83), [Sean Caetano Martin](http://www.xonecas.com/), [Yuya Saito](http://css.studiomohawk.com/), [Zee-Julien](https://github.com/Zee-Julien)


### v.0.9.5 : October 25th, 2010

Major changes:

<ul>
<li>Removed <code>-webkit-font-smoothing: antialiased;</code> it makes monospace too thin.</li>
<li>IE conditional classes have moved from the <code>&lt;body&gt;</code> tag to the <code>&lt;html&gt;</code> tag ( #44 ).</li>
<li>Dropped <code>text-rendering: <a href="http://www.aestheticallyloyal.com/public/optimize-legibility/">optimizeLegibility</a></code> as it breaks small-caps, looks odd on Linux machines, and goes invisible on WebOS.</li> 
<li>Added a IE6 call for the minified <code>dd_belatedpng</code>.</li>
<li>Revised viewport declaration to allow user scaling and clear Webkit console errors ( #37 ).</li>
<li>Updated Modernizr to 1.6 </li>
<li>Added <code>web.config</code> file for Microsoft IIS</li>
<li>Beta release of the <a href="http://github.com/paulirish/html5-boilerplate/wiki/Build-script">Build Script</a> (this is HUGE)</li>
<li>New project scaffolding <a href="http://github.com/paulirish/html5-boilerplate/wiki/makep.sh">bash script</a>.</li>
</ul>

#### General
* Updated Modernizr to 1.6 (smaller and faster)
* Added web.config file for Microsoft IIS. Now forcing latest IE version and ChromeFrame, if installed.
* Added favicon and default icon for iOS.
* Updated crossdomain.xml wording for better security guidelines ( #124 ).
* Expires value for nginx.conf corrected.
* License clarified.

#### style.css
* Removed -webkit-font-smoothing: antialiased; as it made monospace too thin.
* Updated fonts normalization to YUI 3.2.0 PR1.
* Table Header set explicitly for IE6 and table row now has page-break: avoid in print CSS.
* text-shadow:none !important set for all text in print css.
* Removed scrollbar from textareas in IE.
* Fixed textarea stylings and form field treatment for validity. Added default background-color.
* New robust clearfix solution without IE 5.5 hack ( #45 #126 ).
* Margins for form-elements explicitly set to 0 as webkit adds 2px space around form elements' chrome. 
* Dropped text-rendering: optimizeLegibility as it breaks small-caps and looks odd on Linux machines. 
* Lists now have a left margin of 1.8em. Default list-style-type for ordered list is decimal.
* Image Replacement now works with right-to-left text ( #68 ).
* Removed "Star Hack" for checkboxes in favor of .ie7 selector.

#### index.html
* IE conditional classes have moved from the <body> tag to the <html> tag ( #44 ).
* Added a IE6 call for the minified dd_belatedpng.
* Google Analytics script will now work with SSL in IE6.
* Added protocol independent absolute path for cdn jquery, with improved fallback-to-local code to protect against edge case IE bug.
* Commented out handheld CSS ( #73 ).
* Mobile viewport and textsize styles adjusted per group feedback ( #37 ).

#### .htaccess
* More files are served via gzip like .htc ( #55 ).
* Added Expires header for content types image/gif and video/webm.
* Fixed favicon display in IE6 ( #113 ).
* Corrected mimetypes for fonts.
* Removed caching for files of type json/xml.
* Better use of ifmodule for more stability in different Apache environments.

[View full diff and commit history](http://github.com/paulirish/html5-boilerplate/compare/v0.9.1...v0.9.5)


#### Contributors
Shi Chuan, Rob Larsen, Ivan Nikolić, Mikko Tikkanen, Velir, Paul Neave, Weston Ruter, Jeffrey Barke, Robert Meissner, SirFunk, Philip von Bargen, Kroc Camen, Rick Waldron, Andreas Madsen, Marco d'Itri, Adeelejaz, James Rosen, Dave DeSandro, Ken Newman, Daniel Lenz, Swaroop C H, Yann Mainier, Joe Sak, Irakli, Rob Flaherty, Jeff Starr, Mike Lamb, Holek, Aaron Peters, Kaelig, Meander, Charlie Ussery, Ciney, Région Wallonne, Sirupsen, and Paul Hayes.



### v.0.9.1 : August 13th, 2010
* HTML5 Boilerplate is now in the Public Domain
* Nginx configuration added
* Font stacks (sans-serif and monospace) simplified
* Very accessible a:focus styles.
* Corrected IE=edge,chromeframe enabling (As a result, the base HTML [does not validate](http://bit.ly/cGSSgr))
* ServerSideIncludes disabled by default.
* Apache config bugfixes
* Conditional body tag class combined 
* dd_belatedPNG updated to 0.0.8. Redundant BackgroundImageCache fix removed.

[View full diff and commit history](http://github.com/paulirish/html5-boilerplate/compare/v0.9...v0.9.1)

##### Thanks:

voodootikigod, garowetz, fearphage, christopherjacob, mathias bynens, daniel harttman, rse, chris dary, erik dahlstrom, timwillison, kenneth nordahl, riddle, elcuervo, andreas kuckartz, 3rdEden, riley willis, majic3

### v0.9 : August 10th, 2010 - Initial release


## License:

Major components:

* Modernizr: MIT/BSD license
* jQuery: MIT/GPL license
* DD_belatedPNG: MIT license
* YUI Profiling: BSD license
* HTML5Doctor CSS reset: Public Domain
* CSS Reset Reloaded: Public Domain

Everything else:

* [The Unlicense](http://unlicense.org) (aka: public domain) 


## Summary:

This is a set of files that a front-end developer can use to get started on a website, with following included:

1. Cross-browser compatible (IE6, yeah we got that.)
2. HTML5 ready. Use the new tags with certainty.
3. Optimal caching and compression rules for grade-A performance
4. Best practice site configuration defaults
5. Think there's too much? The HTML5 Boilerplate is delete-key friendly. :)
6. Mobile browser optimizations
7. Progressive enhancement graceful degredation ........ yeah yeah we got that
8. IE specific classes for maximum cross-browser control
9. Want to write unit tests but lazy? A full, hooked up test suite is waiting for you.
10. Javascript profiling.. in IE6 and IE7? Sure, no problem.
11. Console.log nerfing so you won't break anyone by mistake.
12. Never go wrong with your doctype or markup!
13. An optimal print stylesheet, performance optimized
14. iOS, Android, Opera Mobile-adaptable markup and CSS skeleton.
15. IE6 pngfix baked in.
16. jQuery, waiting for you

## Releases 

There are two releases: a documented release, which is exactly what you see here, and a "stripped" release, with most of the descriptive comments stripped out.

Watch the [current tickets](http://github.com/paulirish/html5-boilerplate/issues) to view the areas of active development.

