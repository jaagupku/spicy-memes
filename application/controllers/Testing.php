<?php
class Testing extends CI_Controller {

        public function view($page = 'test')
        {
			if ( ! file_exists(APPPATH.'views/test/'.$page.'.php'))
			{
					// Whoops, we don't have a page for that!
					show_404();
			}

			$this->load->view('test/'.$page);
        }
}
?>