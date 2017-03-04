<?php
/**
 * https://github.com/kojiflowers/cloudinary-for-codeigniter
 * This is a "dummy" library that just loads the actual library in the construct.
 * This technique prevents issues from CodeIgniter 3 when loading libraries that use PHP namespaces.
 * This file can be used with any PHP library that uses namespaces.  Just copy it, change the name of the class to match your library
 * and configs and go to town.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
// Setup the dummy class for Cloudinary
class Cloudinarylib {
    public function __construct()
    {
        // include the cloudinary library within the dummy class
        require('cloudinary/Cloudinary.php');
        require 'cloudinary/Uploader.php';
        require 'cloudinary/Api.php';
        // configure Cloudinary API connection
        if (file_exists('application/config/cloudinary.php')) {
          include 'application/config/cloudinary.php';
        }
    }

    public function get_html_data($data_type, $data, $width=560) {
      if ($data_type=="P") {
         return cl_image_tag($data, array("width" => $width, "crop"=>"limit"));
      } else {
         return "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/{$data}\" frameborder=\"0\" allowfullscreen></iframe>";
      }
    }
}
