<?php
/* Smarty version 4.1.1, created on 2023-08-16 07:52:07
  from 'D:\codes\citest\framework\application\views\templates\button.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.1.1',
  'unifunc' => 'content_64dc64072d9cd4_05745332',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6168c1599c8ab1cc93e5c3fdd5e42d98679c335e' => 
    array (
      0 => 'D:\\codes\\citest\\framework\\application\\views\\templates\\button.html',
      1 => 1692165123,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64dc64072d9cd4_05745332 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>

<head>
    <!-- <?php echo '<script'; ?>
 type="text/javascript"> 
<?php echo '</script'; ?>
> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

</head>

<body>
    <form method="get" action="http://localhost/loller/index">
        <button style="width:200px; height:100px" type="submit"></button>
    </form>
    <form method="get" action="http://localhost/loller/download?original_pdf=APPPATH . 'public/pdf/bruh.pdf'">
        <button style="width:200px; height:100px" type="submit"></button>
    </form>




    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
        Launch static backdrop modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ... <iframe src=" <?php echo '<?php'; ?>
 ehco APPPATH . 'public/pdf/bruh.pdf'; <?php echo '?>'; ?>
 "></iframe>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>









    <!-- <div id="handout_wrap_inner"></div> -->


    <?php echo '<script'; ?>
 type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"><?php echo '</script'; ?>
>

</body>



</html><?php }
}
