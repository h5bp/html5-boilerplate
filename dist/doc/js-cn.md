[HTML5 Boilerplate 主页](https://html5boilerplate.com/) | [目录](TOC.md)

# JavaScript

该项目中包含的默认JavaScript的信息

## main.js

该文件可用于包含或引用你的网站/应用程序的JavaScript代码。如果你正在处理更高级的内容，可以完全替换此文件。这很酷。

## plugins.js

对于简单的网站，该文件可用于包含你的所有插件，例如jQuery插件和其它第三方脚本。

一种方法是将jQuery插件放在一个`(function($){ ... })(jQuery);`封闭函数中，以确保它们位于jQuery命名空间安全集中。阅读更多关于[jQuery插件创作](https://learn.jquery.com/plugins/#Getting_Started)。

By default the `plugins.js` file contains a small script to avoid `console` errors in browsers that lack a `console`. The script will make sure that, if a console method isn't available, that method will have the value of empty function, thus, preventing the browser from throwing an error.
默认情况下，`plugins.js`文件包含一个小脚本，以避免在没有`console`的浏览器中出现`console`错误。该脚本将确保如果控制台方法不可用时，该方法将具有空函数的值，从而防止浏览器引发错误。

## vendor

此目录可用于包含所有的第三方库代码。

默认情况下，包含最新的jQuery和Modernizr库的精简版本。你可能希望使用[在线构建器](https://www.modernizr.com/download/)或[命令行工具](https://modernizr.com/docs#command-line-config)创建自己的[定制Modernizr]。
