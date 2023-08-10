<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends CI_Controller
{

    public function view($page = "home")
    {

        error_log(APPPATH . 'views/pages/' . $page . '.php');
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404(); // error:404
        }


        $data['title'] = ucfirst($page);
        echo ($data['title']);
        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
        $this->load->view('phpproject2023/web');
    }
}
