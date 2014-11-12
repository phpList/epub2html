<?php

/*
 * ePub2HTML - quick-n-dirty script to take an ePub and show it as HTML
 * used for the phpList Manual, edited on flossmanuals.org
 * 
 * v.01 - 11/11/2014 - MD initial release
 * 
 * license GPLv3 or later
 * 
 */

$headerFile = 'header.html';
$footerFile = 'footer.html';
$tocFile = 'toc.ncx';

/* ---------------------- end config -------------- */


$tocFile = simplexml_load_file(dirname(__FILE__).'/'.$tocFile);
$title = $tocFile->docTitle->text;
$toc = extractMenu($tocFile->navMap->navPoint);

$header = file_get_contents(dirname(__FILE__).'/'.$headerFile);
$footer = file_get_contents(dirname(__FILE__).'/'.$footerFile);

$file = $_SERVER['REQUEST_URI'];
$file = basename($file);
if (is_file(dirname(__FILE__).'/'.$file)) {
  $contents = file_get_contents(dirname(__FILE__).'/'.$file);
} 

$contents = str_replace('<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><title/>','',$contents);

$contents = str_replace('</head><body>','',$contents);
$contents = str_replace('</body></html>','',$contents);

$header = str_replace('[TITLE]',$title,$header);

print $header;
print '<table><tr><td valign="top">';
print $toc;
print '</td><td valign="top">';
print $contents;
print '</td></tr></table>';
print $footer;

function extractMenu($navPoints,$level = 1) {
  $menu = '<ul class="menu level'.$level.'">';
  foreach ($navPoints as $navPoint) {
    $menu .= '<li class="menuitem itemlevel'.$level.'">';
    $menu .=  '<a href="';
    $menu .= $navPoint->content['src'];
    $menu .= '">';
    $menu .=  $navPoint->navLabel->text;
    $menu .= '</a>';
    
    if (!empty($navPoint->navPoint)) {
      $menu .= extractMenu($navPoint->navPoint,$level++);
    }
    $menu .= '</li>';
  }
  $menu .= '</ul>';
  return $menu;
}


