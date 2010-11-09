#  HTML5 Boilerplate [http://html5boilerplate.com](http://html5boilerplate.com)

## Changelog:

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

voodootikigod, garowetz, fearphage, christopherjacob, mathias byenens, daniel harttman, rse, chris dary, erik dahlstrom, timwillison, ken nordahl, riddle, elcuervo, andreas kuckartz, 3rdEden, riley willis, majic3

### v0.9 : August 10th, 2010 - Initial release


## License:

Major components:

* Modernizr: MIT/BSD license
* jQuery: MIT/GPL license
* DD_belatedPNG: MIT license
* YUI Profiling: BSD license
* HTML5Doctor CSS reset: Creative Commons 3.0 BY
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

