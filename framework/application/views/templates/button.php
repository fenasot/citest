<!DOCTYPE html>
<html>

<head>
    <!-- <script type="text/javascript">
</script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

</head>

<body>
    <form method="get" action="http://localhost/loller/index">
        <button style="width:200px; height:100px" type="submit">下載預覽PDF</button>
    </form>
    <form method="get" action="http://localhost/loller/index">
        <button style="width:200px; height:100px" type="submit">下載整份PDF</button>
    </form>
    <form method="get" action="http://localhost/loller/download_all_watermark_small">
        <button style="width:200px; height:100px" type="submit">下載整份PDF(small)</button>
    </form>
    <form method="get" action="http://localhost/loller/test2">
        <button style="width:200px; height:100px" type="submit">原檔案</button>
    </form>





    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
        Launch static backdrop modal
    </button>

    <!-- Modal -->




    <div class="modal_pdf modal fade " id="staticBackdrop">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">pdf_preview</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body"><iframe id="pdf_preview" src="{{$pdf_source}}" style="width:100%; height: 850px;"></iframe>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>





    <!-- <div id="handout_wrap_inner"></div> -->


    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>

</body>



</html>
