<?php
defined('BASEPATH') or exit('No direct script access allowed');

class phpinfo extends CI_Controller
{
    public function index()
    {
        $this->load->view('errors/phpinfo');
    }
}
