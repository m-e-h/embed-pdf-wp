<?php
/*
Plugin Name: PDF Embed
Plugin URI: https://github.com/m-e-h/embed-pdf-wp
Description: Embed PDFs with pdf.js and a shortcode
Version: 1.2
Author: Marty Helmick
Author URI: http://martyhelmick.com
License: GPLv2
*/
//tell wordpress to register the pdfjs-viewer shortcode
add_shortcode("pdfjs-viewer", "pdfjs_handler");

function pdfjs_handler($incomingfrompost) {
  //set defaults 
  $incomingfrompost=shortcode_atts(array(
    'url' => 'bad-url.pdf',  
    'viewer_height' => '1360px',
    'viewer_width' => '100%',
    'presentationMode' => 'true',
    'download' => 'true',
    'print' => 'true',
    'openfile' => 'false'
  ), $incomingfrompost);
  //run function that actually does the work of the plugin
  $pdfjs_output = pdfjs_function($incomingfrompost);
  //send back text to replace shortcode in post
  return $pdfjs_output;
}

function pdfjs_function($incomingfromhandler) {
  $siteURL = home_url();
  $viewer_base_url= $siteURL."/wp-content/plugins/pdf-embed-wp/web/viewer.php";
  
  $file_name = $incomingfromhandler["url"];
  $viewer_height = $incomingfromhandler["viewer_height"];
  $viewer_width = $incomingfromhandler["viewer_width"];
  $presentationMode = $incomingfromhandler["presentationMode"];
  $download = $incomingfromhandler["download"];
  $print = $incomingfromhandler["print"];
  $openfile = $incomingfromhandler["openfile"];
  
  if ($download != 'true') {
      $download = 'false';
  }
  
  if ($print != 'true') {
      $print = 'false';
  }
  
  if ($openfile != 'true') {
      $openfile = 'false';
  }
  
  $final_url = $viewer_base_url."?file=".$file_name."&download=".$download."&print=".$print."&openfile=".$openfile;
  
  $presentationMode_link = '';
  if($presentationMode == 'true'){
       $presentationMode_link = '<a href="'.$final_url.'">View Fullscreen</a><br>';
  }
  $iframe_code = '<iframe width="'.$viewer_width.';" height="'.$viewer_height.';" src="'.$final_url.'"></iframe> ';
  
  return $presentationMode_link.$iframe_code;
}
?>