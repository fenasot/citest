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

        // $img->readImage(APPPATH . 'public/image/bruh.png');
        $img->readImage(APPPATH . 'public/pdf/bruh.pdf[0]');
        $img->thumbnailImage(1000, 0);
        $img->borderImage(new ImagickPixel("white"), 5, 5);
        $img->setImageResolution(600, 600);
        $imgs = $img->appendImages(true);
        $imgs->setImageFormat("png");
        // $img->setImageFilename("logo.png");
        $imgs->writeImage(APPPATH . 'public/image/logo.png');
        // if (!$img->writeImage()) {
        //     echo 'Write image failed: ' . $img->getLastErrorMessage();
        // }

        // ob_start();
        // header("Content-Type: image/jpg");

        // if (!$this->image_lib->resize()) {
        //     echo $this->image_lib->display_errors();
        // }
        // $this->image_lib->resize();

        header("Content-Type: image/png");
        header('Content-Disposition: attachment;filename=test.png');
        header('Cache-Control: max-age=0');

        $this->test();

    }

    public function test()
    {

        $target_image = APPPATH . 'public/image/logo.png'; // 要加上浮水印的目標
        // echo $target_image;
        $target_image_info = getimagesize($target_image);
        echo $target_image_info[0];
        $target_image_width = $target_image_info[0]; // 目標的width
        $target_image_height = $target_image_info[1]; // 目標的height
        $watermark_image = APPPATH . 'public/image/watermark.png'; // 浮水印圖片
        $resized_watermark_image = APPPATH . 'public/image/watermark_test.png'; // 調整成目標長寬的浮水印圖片

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
        $config['new_image'] = APPPATH . 'public/image/result.png';
        // 浮水印圖片設定
        $config['wm_type'] = 'overlay';
        $config['wm_overlay_path'] = $resized_watermark_image;
        $config['quality'] = '100%';
        $config['wm_opacity'] = 20;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $result_link = APPPATH . 'public/image/result.png';
        $resize_link = APPPATH . 'public/image/watermark_test.png';

        if (!$this->image_lib->watermark()) {
            echo $this->image_lib->display_errors();
        } //else {
        //     $this->ci_smarty->v->assign('image_link', $result_link);
        //     $this->ci_smarty->v->assign('image1_link', $resize_link);
        //     $this->ci_smarty->v->display('test.html');
        //     $this->ci_smarty->v->display('footer.html');
        // }

        // force_download("test.png", file_get_contents($result_link));
    }
}
