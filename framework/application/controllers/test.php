<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Test extends CI_Controller
{
    public function tester()
    {
        $this->load->helper('url');

        // 获取URL中的段落（index从0开始计数）
        $page = $this->uri->segment(2);
        // 如果没有，则默认为'test'
        if (empty($page)) {
            $page = 'test';
        }
        $this->load->view('templates/bootheader');
        $this->load->view('bootstraptest/' . $page);
        $this->load->view('bootstraptest/test');
        $this->load->view('templates/bootfooter');
        $this->load->view('templates/footer');
    }
}
