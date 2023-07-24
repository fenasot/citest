<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'third_party/smarty/Smarty.class.php';

$smarty = new Smarty();
$smarty->setTemplateDir(APPPATH . 'views/templates');
$smarty->setCompileDir(APPPATH . 'views/templates_c');
$smarty->setCacheDir(APPPATH . 'views/cache');
$smarty->setConfigDir(APPPATH . 'views/configs');

// 你可以在这里添加任何其他 Smarty 配置选项

/* End of file smarty_config.php */
