<?php
   class Main extends CI_Controller {
     public function view($page = 'header')
     {
             if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
             {
                     // Whoops, we don't have a page for that!
                     show_404();
             }


             $this->load->view('pages/'.$page);
     }
   }
?>
