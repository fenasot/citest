<?php
/* Smarty version 4.1.1, created on 2023-08-21 07:57:19
  from 'D:\codes\citest\framework\application\views\templates\showpdf.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.1.1',
  'unifunc' => 'content_64e2fcbf43baf0_69276663',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0e791cf1ddde11def06f81a846ca042ec01a03d7' => 
    array (
      0 => 'D:\\codes\\citest\\framework\\application\\views\\templates\\showpdf.html',
      1 => 1692597437,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64e2fcbf43baf0_69276663 (Smarty_Internal_Template $_smarty_tpl) {
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
