<?php

class Main extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('cloudinarylib');
        $this->load->model('meme_model');
    }

    public function index() {
        $data['memes'] = $this->meme_model->get_hot_memes(0, 20);

        foreach ($data['memes'] as $key => $row) {
          if ($row['Data_Type']=="P") {
             $data['memes'][$key]['Data']=cl_image_tag($row['Data'], array("width" => 560, "crop"=>"limit"));
          } else {
             $data['memes'][$key]['Data']="<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/{$row['Data']}\" frameborder=\"0\" allowfullscreen></iframe>";
          }
        }

        $this->load->view('pages/header', array('username' => $this->session->username));
        $this->load->view('pages/testmemebody.php', $data);
        $this->load->view('pages/footer.php');
    }

    public function view($page = 'header') {
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $this->load->view('pages/' . $page);
    }
}

?>
