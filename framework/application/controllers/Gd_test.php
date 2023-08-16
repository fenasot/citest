<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gd_test extends CI_Controller
{


    public function index()
    {
        $config['source_image'] = APPPATH . 'public/image/bruh.png';
        $config['create_thumb'] = FALSE;
        $config['file_permissions'] = 0777;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 750;
        $config['height'] = 500;
        $config['new_image'] = APPPATH . 'public/image/bruh_test.png';

        $this->image_lib->initialize($config);

        // if (!$this->image_lib->resize()) {
        //     echo $this->image_lib->display_errors();
        // }
        $this->image_lib->resize();

        $test_image_lib_url = base_url('application/public/image/bruh.png');
        echo APPPATH . 'public/image/bruh_test.png' . "<br>";
        echo $test_image_lib_url;


        
        $data = array(
            'title' => "Welcome to the summoner's rift",
            'content' => "Thirty seconds until minions spawn",
            'test_image_url' =>$test_image_lib_url,
        );
        
        $this->smarty_library->assign($data);
        $this->load->view('templates/button');
        $this->smarty_library->display('welcome_message.php');



        
    }
}
