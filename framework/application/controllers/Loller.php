<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Loller extends CI_Controller
{

    public function index()
    {
        // $config['image_library'] = 'ImageMagick';
        // $config['library_path'] = 'D:\installed\ImageMagick-7.1.1-Q8';
        // $config['source_image'] = APPPATH . 'public/image/bruh.png';
        // $config['create_thumb'] = true;
        // $config['new_image'] = APPPATH . 'public/image/bruh_pdffile.png';
        // $config['maintain_ratio'] = true;
        // $config['width'] = 200;
        // $config['height'] = 150;
        // if (!$this->image_lib->initialize($config)) {
        //     echo 'errorrrrrrrrrrrrrrrrrrrrrrrrrrrrr';
        // }
        // if (!$this->image_lib->resize()) {
        //     echo $this->image_lib->display_errors();
        // }

        $img = new Imagick();
        $img->readImage(APPPATH . 'public/pdf/bruh.pdf[0]');//選擇目的文件
        $img->thumbnailImage(1000, 0);                      //設定長寬比
        $img->borderImage(new ImagickPixel("white"), 5, 5); //背景顏色
        $img->setImageResolution(900, 900);                 //每英吋像素
        $img->setImageCompressionQuality(100);
        $imgs = $img->appendImages(true);                   //是否合成多張圖片
        $imgs->setImageFormat("png");       //轉檔
        $img->setImageFormat("png");        //轉檔
        // $imgs->setImageFilename("logo.png");
        // $imgs->writeImage(APPPATH . 'public/cache/rewriteimage.png');     //將轉檔後的檔案放置cache資料夾並準備上浮水印

        if (!$imgs->writeImage(APPPATH . 'public/cache/rewriteimage.png')) { //轉檔位置與檔名
            echo '<script>alert("轉換文件失敗")</script>';
        }

        // $this->image_lib->resize();

        header("Content-Type: image/png");                            //設置偵測的副檔名
        header('Content-Disposition: attachment;filename=test.png');  //預設下載檔名
        header('Cache-Control: max-age=0');                           //不緩存
        // // header後的程式碼都將被送至輸出流而不呈現於網頁上
        // echo file_get_contents(APPPATH . 'public/cache/rewriteimage.png');
        echo $img;
        // $this->watermark(); //呼叫watermark

    }

    public function watermark()
    {

        $target_image = APPPATH . 'public/cache/rewriteimage.png'; // 要加上浮水印的目標
        // echo $target_image;
        $target_image_info = getimagesize($target_image);
        echo $target_image_info[0];
        $target_image_width = $target_image_info[0]; // 目標的width
        $target_image_height = $target_image_info[1]; // 目標的height
        $watermark_image = APPPATH . 'public/image/watermark.png'; // 浮水印圖片
        $resized_watermark_image = APPPATH . 'public/cache/watermark_test.png'; // 調整成目標長寬的浮水印圖片

        // resize 浮水印長寬
        $config['source_image'] = $watermark_image;
        $config['new_image'] = $resized_watermark_image;
        $config['maintain_ratio'] = false;
        $config['width'] = $target_image_width;
        $config['height'] = $target_image_height;
        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();

        // 加上浮水印
        $config['source_image'] = $target_image;
        $config['new_image'] = APPPATH . 'public/cache/result.png';
        // 浮水印圖片設定
        $config['wm_type'] = 'overlay';
        $config['wm_overlay_path'] = $resized_watermark_image;
        $config['quality'] = '100%';
        $config['wm_opacity'] = 20;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $result_link = APPPATH . 'public/cache/result.png';
        $resize_link = APPPATH . 'public/cache/watermark_test.png';

        if (!$this->image_lib->watermark()) {
            echo $this->image_lib->display_errors();
        } //else {
        //     $this->ci_smarty->v->assign('image_link', $result_link);
        //     $this->ci_smarty->v->assign('image1_link', $resize_link);
        //     $this->ci_smarty->v->display('test.html');
        //     $this->ci_smarty->v->display('footer.html');
        // }
        $this->returnpdf($result_link);
        // force_download("test.png", file_get_contents($result_link));
    }

    public function returnpdf($imgs_link)
    {
        // $config['image_library'] = 'ImageMagick';
        // $config['library_path'] = 'D:\installed\ImageMagick-7.1.1-Q8';
        // $config['source_image'] = APPPATH . 'public/image/bruh.png';
        // $config['create_thumb'] = true;
        // $config['new_image'] = APPPATH . 'public/image/bruh_pdffile.png';
        // $config['maintain_ratio'] = true;
        // $config['width'] = 200;
        // $config['height'] = 150;
        // if (!$this->image_lib->initialize($config)) {
        //     echo 'errorrrrrrrrrrrrrrrrrrrrrrrrrrrrr';
        // }
        // if (!$this->image_lib->resize()) {
        //     echo $this->image_lib->display_errors();
        // }

        $result_link = APPPATH . 'public/cache/rewritepdf.pdf';
        $img = new Imagick();
        $img->readImage($imgs_link);
        $img->thumbnailImage(1000, 0);
        $img->borderImage(new ImagickPixel("white"), 5, 5);
        $img->setImageResolution(60, 60);
        $imgs = $img->appendImages(true);

        $imgs->setImageFormat("pdf");
        // $imgs->setImageFilename("logo.png");
        $imgs->writeImage($result_link); //將轉檔成功後的檔案放置cache資料夾

        // header("Content-Type: image/png");                            //設置偵測的副檔名
        // header('Content-Disposition: attachment;filename=test.png');  //預設下載檔名
        // header('Cache-Control: max-age=0');                           //不緩存
        // // header後的程式碼都將被送至輸出流而不呈現於網頁上

        // echo file_get_contents($result_link);

        // $this->showpdf($result_link);
        force_download("review.pdf", file_get_contents($result_link));
    }

    public function showpdf($result_link) //失敗
    {
        try {
            // $url = !empty($_GET['url']) ? $_GET['url'] : die('error');
            // $page = isset($_GET['p']) ? $_GET['p'] - 1 : '0';
            $page = 0;
            $file_name = 'temp_' . mt_rand(1000, 9999) . 'pdf';
            // file_put_contents('./' . $file_name, file_get_contents($url));
            file_put_contents($result_link);
            $imagePreview = new imagick('./' . $file_name . '[' . $page . ']');
            $imagePreview->setImageFormat("jpg");
            // $imagePreview->setResolution( 900, 900 );
            header("Content-Type: image/jpeg");
            echo $imagePreview;
            unlink('./' . $file_name);
        } catch (\Exception $e) {
            echo '发生错误';
        }
    }

}
