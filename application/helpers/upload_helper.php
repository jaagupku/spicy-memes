<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/cloudinary/Cloudinary.php';
require APPPATH . 'third_party/cloudinary/Uploader.php';
require APPPATH . 'third_party/cloudinary/Api.php';

if (file_exists('application/config/cloudinary.php')) {
    include 'application/config/cloudinary.php';
}

function upload_image($controller, $input_name) {
    $config['upload_path'] = './temp/';
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size'] = '4096';

    $controller->load->library('upload', $config);

    if ($controller->upload->do_upload($input_name)) {
        return upload_link($controller, $controller->upload->data()['full_path']);
    } else {
        return false;
    }
}

function upload_link($controller, $link) {
    return \Cloudinary\Uploader::upload($link);
}
