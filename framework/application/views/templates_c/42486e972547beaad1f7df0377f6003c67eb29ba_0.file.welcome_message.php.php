<?php
/* Smarty version 4.1.1, created on 2023-08-15 10:25:46
  from 'D:\codes\citest\framework\application\views\templates\welcome_message.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.1.1',
  'unifunc' => 'content_64db368a239653_71528328',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '42486e972547beaad1f7df0377f6003c67eb29ba' => 
    array (
      0 => 'D:\\codes\\citest\\framework\\application\\views\\templates\\welcome_message.php',
      1 => 1692080976,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64db368a239653_71528328 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>

<head>
    <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
</head>

<body>
    <br>
    <img src="<?php echo $_smarty_tpl->tpl_vars['test_image_url']->value;?>
">
    <!-- <img src="/public/image//bruh.png"> -->
    <h1><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h1>
    <p><?php echo $_smarty_tpl->tpl_vars['content']->value;?>
</p>
</body>

</html><?php }
}
