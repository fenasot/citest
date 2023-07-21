<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends CI_Controller
{

    public function view($page = "home")
    {
        var_dump($page);
        error_log(APPPATH . 'views/pages/' . $page . '.php');
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404(); // error:404
        }

        
        $data['title'] = ucfirst($page);

        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }
}
