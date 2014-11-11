epub2html
=========

Convert ePub to HTML

This simple PHP script will take an ePub file and allow publishing it as a browseable set of pages.

To install:

Assuming the location of the ePub on a website in /manual/

1. Add the following to the Apache VHOST (assuming Mod Rewrite is available)

  RewriteRule ^/manual/(.*).xhtml /manual/index.php/$1 [PT]

2. Download the ePub file in the manual directory and type "unzip file.epub"

Browse to http://www.website.com/manual/

For formatting, update the header.html and footer.html. The current ones are for phpList.


