<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'third_party/smarty/Smarty.class.php';

class Smarty_library extends Smarty
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplateDir(APPPATH . 'views/templates/');
        $this->setCompileDir(APPPATH . 'views/templates_c/');
        $this->setCacheDir(APPPATH . 'views/cache/');
        // $this->setConfigDir(APPPATH.'third_party/Smarty/configs');
    }
}
