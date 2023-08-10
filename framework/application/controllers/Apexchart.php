<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Apexchart extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url'); // 載入 url 助手
    }


    public function apex($page = "home")
    {

        error_log(APPPATH . 'views/apexchart/apex.php');
        if (!file_exists(APPPATH . 'views/apexchart/apex.php')) {
            show_404(); // error:404
        }

        $this->load->view('apexchart/apex');
        
        $this->load->view('apexchart/count');
    }
}
