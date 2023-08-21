<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gd_test extends CI_Controller
{
    public function index()
    {
        $config['source_image'] = APPPATH . 'public/image/bruh.png';
        $config['create_thumb'] = false;
        $config['file_permissions'] = 0777;
        $config['maintain_ratio'] = true;
        $config['width'] = 750;
        $config['height'] = 500;
        $config['new_image'] = APPPATH . 'public/image/bruh_test.png';
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $test_image_lib_url = base_url('application/public/image/bruh.png');
        $original_pdf = base_url('application/public/cache/output.pdf');
        echo APPPATH . 'public/image/bruh_test.png' . "<br>";
        echo $test_image_lib_url . "<br>";
        echo $original_pdf;

        $data = array(
            'title' => "Welcome to the summoner's rift",
            'content' => "Thirty seconds until minions spawn",
            'test_image_url' => $test_image_lib_url,
            'pdf_source' => $original_pdf,
        );

        $this->smarty_library->assign($data);
        $this->smarty_library->display('showpdf.html');
        $this->smarty_library->display('button.php');

    }
}
