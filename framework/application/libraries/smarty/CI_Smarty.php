<?php

/**
 * =======================================
 * Created by PK Technology.
 * Author: ZhiHua_W
 * Date: 2016/10/31 0031
 * Time: 上午 9:16
 * Project: CI整合
 * Power: CI框架整合smarty
 * =======================================
 */
defined('BASEPATH') or exit('No direct script access allowed');
require(APPPATH . 'libraries/smarty/Smarty.class.php');
class CI_Smarty extends Smarty
{
    public function __construct($template_dir = '', $compile_dir = '', $config_dir = '', $cache_dir = '')
    {
        parent::__construct();
        if (is_array($template_dir)) {
            foreach ($template_dir as $key =>  $value) {
                $this->$key = $value;
            }
        } else {
            //ROOT是Codeigniter在入口文件index.php定义的本web应用的根目录
            $this->template_dir = $template_dir ? $template_dir : ROOT . '/templates';
            $this->compile_dir = $compile_dir ? $compile_dir : ROOT . '/templates_c';
            $this->config_dir = $config_dir ? $config_dir : ROOT . '/config';
            $this->cache_dir = $cache_dir ? $cache_dir : ROOT . '/cache';
        }
    }
}
