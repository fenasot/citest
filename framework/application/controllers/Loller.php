<?php
defined('BASEPATH') or exit('No direct script access allowed');

//cache_path 用於設定轉檔與上浮水印過程中使用的資料夾
//watermark_path 用於設定浮水印檔案的儲存資料夾
//font_file 用於設定生成圖片所用的字型檔路徑

class Loller extends CI_Controller
{
    public $cache_path = APPPATH . 'public/cache/';
    public $watermark_path = APPPATH . 'public/image/watermark/';
    public $font_file = 'C:/windows/fonts/msjhl.ttc';

    public function index()
    {
        $source_ask = array(
            $original_pdf = APPPATH . 'public/pdf/bruh.pdf',
            $pdf_page = 4,
        );
        $uid = 'EC0000001';
        $name = '維大利';

        $this->download_all_watermark($source_ask, $uid, $name);
    }

    //source_info[0] = 檔案名稱，source_info[1] = 檔案位址
    public function download($source_info)
    {
        force_download($source_info[0], file_get_contents($source_info[1]));
    }

    //已棄用
    // public function change_pdf_to_img($source_info)
    // {
    //     $img = new Imagick();
    //     $img->setResolution(300, 300); //DPI
    //     $img->readImage($source_info);
    //     $img->thumbnailImage(2000, 0); //resolution
    //     $img->borderImage(new ImagickPixel("white"), 5, 5); //背景顏色
    //     $img->setImageCompressionQuality(100);
    //     $imgs = $img->appendImages(false); //是否合成多張圖片
    //     $imgs->setImageFormat("png");
    //     $imgs->writeImage($this->cache_path . 'rewriteimage.png');

    //     $result_name = 'rewriteimage.png';
    //     $result_link = $this->cache_path . 'rewriteimage.png';

    //     $img->clear();
    //     $img->destroy();

    //     // header("Content-Type: image/png"); //設置偵測的副檔名
    //     // header('Content-Disposition: attachment;filename=test.png'); //預設下載檔名
    //     // header('Cache-Control: max-age=0'); //不緩存
    //     // // header後的程式碼都不呈現於網頁上
    //     // echo file_get_contents($this->cache_path.'rewriteimage.png');
    //     // echo $imgs;

    //     return array(
    //         $result_name, $result_link,
    //     );
    // }

    //TODO: 針對特定頁數下載
    public function change_pdf_to_img_all($source_info)
    {
        $source_pdf = $source_info[0];
        $pdf_page = $source_info[1];
        $img = new Imagick();
        $img->pingImage($source_pdf);

        //是否下載全部頁數
        if ($pdf_page == 'ALL') {
            $pdf_page = $img->getNumberImages();
        }

        //轉檔
        for ($page = 0; $page < $pdf_page; $page++) {
            $img->setResolution(300, 300); //DPI
            $img->readImage($source_pdf . '[' . $page . ']');
            $img->thumbnailImage(1000, 0); //Resolution
            $img->borderImage(new ImagickPixel("white"), 5, 5); //Background Color
            $img->setImageCompressionQuality(100);

            //使用$imgs儲存單頁結果
            $imgs = $img->appendImages(false);
            $imgs->setImageFormat("png");
            $imgs->writeImage($this->cache_path . 'rewriteimage' . $page . '.png');
            $result_name = 'rewriteimage' . $page . '.png';
            $result[$page] = $result_name;
        }
        $img->clear();
        $img->destroy();

        return $result; //File name
    }

    //已棄用
    // public function watermark($image_info, $uid, $name)
    // {
    //     //要加上浮水印的目標，0為檔名 1為位址
    //     $imgs_link = $image_info[1];
    //     $imgs_link_info = getimagesize($imgs_link);
    //     $imgs_link_width = $imgs_link_info[0];
    //     $imgs_link_height = $imgs_link_info[1];
    //     $watermark_image = $this->watermark_path . $uid . '_' . $name . '.png';
    //     $resized_watermark_image = $this->cache_path . 'watermark_test.png';

    //     if (!file_exists($watermark_image)) {
    //         $this->create_watermark($uid, $name);
    //     }

    //     // resize 浮水印長寬
    //     $config['source_image'] = $watermark_image;
    //     $config['new_image'] = $resized_watermark_image;
    //     $config['maintain_ratio'] = false;
    //     $config['width'] = $imgs_link_width;
    //     $config['height'] = $imgs_link_height;
    //     $this->image_lib->clear();
    //     $this->image_lib->initialize($config);
    //     $this->image_lib->resize();

    //     // 加上浮水印
    //     $config['source_image'] = $imgs_link;
    //     $config['new_image'] = $this->cache_path . 'result.png';
    //     $config['wm_type'] = 'overlay';
    //     $config['wm_overlay_path'] = $resized_watermark_image;
    //     $config['quality'] = '100';
    //     $config['wm_opacity'] = 20;
    //     $this->image_lib->clear();
    //     $this->image_lib->initialize($config);
    //     $result_name = 'result.png';
    //     $result_link = $this->cache_path . 'result.png';
    //     $resize_link = $this->cache_path . 'watermark_test.png';
    //     $this->image_lib->watermark();

    //     return array(
    //         $result_name, $result_link,
    //     );
    // }

    //image_info與source_info格式相同
    public function watermark_all($image_name, $uid, $name)
    {
        //image_info為陣列，內容為rewriteimage.png
        $imgs_link = $image_name[0];
        $imgs_link_info = getimagesize($this->cache_path . $imgs_link);
        $imgs_link_width = $imgs_link_info[0];
        $imgs_link_height = $imgs_link_info[1];
        $watermark_image = $this->watermark_path . $uid . '_' . $name . '.png';

        // $config['wm_type'] = 'overlay';
        // $config['wm_overlay_path'] = $watermark_image;
        // $config['quality'] = '100';
        // $config['wm_opacity'] = 100;

        $img = new Imagick();
        $img_watermark = new Imagick($watermark_image);
        $img->setCompressionQuality(100);
        $img->setResolution(100, 100);

        foreach ($image_name as $num => $image) {
            $img->readImage($this->cache_path . $image);
            $img->thumbnailImage($imgs_link_width, $imgs_link_height);
            $img->compositeImage($img_watermark, imagick::COMPOSITE_OVER, 0, 0);

            $img->writeImage($this->cache_path . 'result' . $num . '.png');
            $result_name[] = 'result' . $num . '.png';
            $result_link[] = $this->cache_path . 'result' . $num . '.png';
        }

        return array(
            $result_name, $result_link,
        );
    }

    //小浮水印
    public function watermark_all_smallmark($image_name, $uid, $name)
    {
        //image_name為陣列，內容為rewriteimage.png
        $imgs_link = $image_name[0];
        $imgs_link_info = getimagesize($this->cache_path . $imgs_link);
        $imgs_link_width = $imgs_link_info[0];
        $imgs_link_height = $imgs_link_info[1];
        $watermark_image = $this->watermark_path . $uid . '_' . $name . '.png';
        var_dump($this->watermark_path);
        if (!file_exists($watermark_image)) {
            $this->create_watermark($uid, $name);
        }
        $watermark_size = getimagesize($watermark_image);
        $width = $watermark_size[0];
        $height = $watermark_size[1];
        $padding = 10;
        $columns = ceil($imgs_link_info[0] / $watermark_size[0]);
        $rows = ceil($imgs_link_info[1] / $watermark_size[1]);

        $img = new Imagick();
        $img_watermark = new Imagick($watermark_image);

        $img->setCompressionQuality(100);
        $img->setResolution(100, 100);

        // 加上浮水印
        foreach ($image_name as $num => $image) {
            $img->readImage($this->cache_path . $image);
            $img->thumbnailImage($imgs_link_width, $imgs_link_height);

            for ($row = 0; $row < $rows; $row++) {
                for ($col = 0; $col < $columns; $col++) {
                    $x = $col * ($width + $padding) + $padding;
                    $y = $row * ($height + $padding) + $padding;
                    $img->compositeImage($img_watermark, imagick::COMPOSITE_OVER, $x, $y);
                }
            }

            $img->writeImage($this->cache_path . 'result' . $num . '.png');
            $result_name[] = 'result' . $num . '.png';
            $result_link[] = $this->cache_path . 'result' . $num . '.png';
        }

        return array($result_name, $result_link);
    }

    // 已棄用
    // public function return_pdf($image_info)
    // {
    //     $imgs_link = $image_info[1];
    //     $result_name = 'rewritepdf.pdf';
    //     $result_link = $this->cache_path . 'rewritepdf.pdf';
    //     $img = new Imagick();
    //     //DPI
    //     $img->setResolution(100, 100);
    //     $img->readImage($imgs_link);
    //     //resolution
    //     $img->thumbnailImage(2000, 0);
    //     $img->borderImage(new ImagickPixel("white"), 5, 5);
    //     $img->setImageResolution(60, 60);
    //     $imgs = $img->appendImages(true);
    //     $imgs->setImageFormat("pdf");
    //     $imgs->writeImage($result_link);

    //     return array($result_name, $result_link);
    // }

    //轉回pdf(所有)
    public function change_img_to_pdf($image_name)
    {
        $pdf = new Imagick();
        // $images = array('image1.png', 'image2.png', 'image3.png');
        $images = $image_name;

        foreach ($images as $key => $image) {
            if ($key === 0) {
                foreach ($image as $name) {
                    var_dump($name);
                    $img = new Imagick($this->cache_path . $name);
                    $pdf->addImage($img);
                }
            }
        }
        $pdf->setResolution(100, 100);
        $pdf->setImageFormat('pdf');
        $pdf->writeImages($this->cache_path . 'output.pdf', true);
        $result_name = 'output.pdf';
        $result_link = $this->cache_path . 'output.pdf';
        $pdf->clear();
        $pdf->destroy();

        return array($result_name, $result_link);
    }

    public function create_watermark($uid, $name)
    {
        $img = new Imagick();
        $draw = new ImagickDraw();

        //set font
        $draw->setFontSize(20);
        $draw->setFont('C:/windows/fonts/mingliu.ttc');
        $draw->setFillColor(new ImagickPixel('black'));

        //get text width
        $metrics = $img->queryFontMetrics($draw, $name);
        $width = $metrics['textWidth'];
        $height = $metrics['textHeight'];

        //set image size and color, no idea why transparent can't use in watermark
        $img->newImage($width, $height, new ImagickPixel('white'));
        // $img->newImage($width, $height, new ImagickPixel('transparent'));

        //draw font with height, width and rotate
        $img->annotateImage($draw, 0, 20, 0, $name);
        $img->evaluateImage(Imagick::EVALUATE_MULTIPLY, 0.1, Imagick::CHANNEL_ALPHA);
        $watermark_path = $this->watermark_path . $uid . '_' . $name . '.png';
        $img->writeImage($watermark_path);
    }

    public function add_time($image_info)
    {
        $config['source_image'] = $image_info;
        $config['wm_text'] = date("Y-m-d H:i:s");
        $config['wm_type'] = 'text';
        $config['wm_font_path'] = 'C:/windows/fonts/mingliu.ttc';
        $config['wm_font_size'] = '20';
        $config['wm_font_color'] = '#000000';
        $config['wm_vrt_alignment'] = 'buttom';
        $config['wm_hor_alignment'] = 'right';
        // $config['wm_padding'] = '40';
        $this->image_lib->initialize($config);
        $this->image_lib->watermark();
    }

    public function josh_test($image_info, $uid, $name)
    {
        $image_link = $image_info[0];
        $arr_width_height = $this->get_width_height($this->cache_path . $image_link);
        $words_in_watermark = $name . ' ';

        $words_arr = array();
        $str_width = '';

        $imagick = new Imagick();
        $width = strlen($words_in_watermark) * 10;
        $lineHeight = 35;

        $width_times = floor($arr_width_height[0] * 1.5 / $width) + 1;
        for ($i = 0; $i < $width_times; $i++) {
            $str_width = $str_width . $words_in_watermark;
        }
        $height_times = floor($arr_width_height[1] / $lineHeight) + 1;
        for ($i = 0; $i < $height_times; $i++) {
            array_push($words_arr, $str_width);
        }

        $imagick->newImage($arr_width_height[0], $arr_width_height[1], new ImagickPixel('white'));
        $textColor = new ImagickPixel('#8E8E8E');
        $draw = new ImagickDraw();
        $draw->setFillColor($textColor);
        $draw->setFont($this->font_file);
        $draw->setFontSize(20);

        $x = 0;
        $y = $lineHeight * 2;

        foreach ($words_arr as $line) {
            $imagick->annotateImage($draw, $x, $y, 0, $line);
            $y += $lineHeight;
        }

        $imagick->setImageFormat('png');
        $imagick->evaluateImage(Imagick::EVALUATE_MULTIPLY, 0.3, Imagick::CHANNEL_ALPHA);
        $watermark_path = $this->watermark_path . $uid . '_' . $name . '.png';
        $imagick->writeImage($watermark_path);
    }

    public function get_width_height($result_image)
    {
        $target_image = $result_image;
        $target_image_info = getimagesize($target_image);
        $target_image_width = $target_image_info[0];
        $target_image_height = $target_image_info[1];
        $arr_width_height = array($target_image_width, $target_image_height);
        return $arr_width_height;
    }

    public function test()
    {
        $original_pdf = APPPATH . 'public/pdf/bruh.pdf';
        $pdf_page = "[0]";
        $source_pdf = $original_pdf . $pdf_page;
        $uid = 'EC0000002';
        $name = '維大利';

        $a = $this->change_pdf_to_img($source_pdf);
        $b = $this->watermark($a, $uid, $name);
        $c = $this->return_pdf($b);
        $d = $this->add_time($c);
        $this->download($c);
    }

    public function download_all_watermark_small()
    {
        $source_info = array(
            $original_pdf = APPPATH . 'public/pdf/bruh.pdf', $pdf_page = 4,
        );
        $uid = 'EC0000002';
        $name = '維大利';

        $a = $this->change_pdf_to_img_all($source_info);
        $b = $this->watermark_all_smallmark($a, $uid, $name);
        $c = $this->change_img_to_pdf($b);
        $this->download($c);
    }

    public function download_all_watermark($source_ask, $uid, $name)
    {
        $a = $this->change_pdf_to_img_all($source_ask);
        if (!file_exists($this->watermark_path . $uid . '_' . $name . '.png')) {
            $this->josh_test($a, $uid, $name);
        }
        $b = $this->watermark_all($a, $uid, $name);
        $c = $this->change_img_to_pdf($b);
        $this->download($c);
    }

}
