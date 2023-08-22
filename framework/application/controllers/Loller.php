<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
此程式碼用於將pdf檔案根據使用者名稱附上浮水印，並提供預覽、下載、轉檔功能。

1. 使用前須先安裝ImageMagic與ghostscript，放入系統路徑後，還需將php_imagick.dll放入php的ext資料夾內，使用phpinfo可查看是否成功安裝imagick套件。

ImageMagic 官網: https://imagemagick.org/script/download.php
php_imagick 載點: https://pecl.php.net/package/imagick/3.7.0/windows
GhostScript 官網: https://ghostscript.com/releases/gsdnld.html

2.  若要使用下載功能請呼叫index()，並分別傳入(

目標檔案路徑,
欲下載頁數(0~99分別對應 or 'ALL'下載整份文件),
uid(核對身分用),
name(浮水印文字))。

3.  若要使用預覽功能請呼叫index_preview()，並分別傳入(

目標檔案路徑,
預覽頁數(0~99分別對應 or 'ALL'預覽整份文件),
uid(核對身分用),
name(浮水印文字))。

4. 詳細設定請至__construst內修改。

*/

// Dev log(v0.1.1)(2023/08/21)(By fena)
//
// 1. 移除了大部分轉檔時使用的DPI與解析度設定，只保留開頭的設定以簡化流程。
// 2. 封裝程式以簡化程式複雜度。
// 3. 將Josh的寫的功能合併至一起。

class Loller extends CI_Controller
{
    private $cache_path;
    private $output_path;
    private $watermark_path;
    private $font_file;
    private $font_file_time;
    private $pdf_final_dpi;
    private $pdf_final_resolution;
    private $font_size;
    private $font_size_time;

    public function __construct()
    {
        parent::__construct();

        //此區為重要設定區

        //cache_path 用於設定轉檔與上浮水印過程中使用的資料夾路徑
        $this->cache_path = APPPATH . 'public/cache/';

        //output_path 用於設定最終輸出的資料夾路徑
        $this->output_path = APPPATH . 'public/cache/';

        //watermark_path 用於設定儲存浮水印檔案的資料夾路徑
        $this->watermark_path = APPPATH . 'public/image/watermark/';

        //font_file 用於設定生成背景浮水印所用的字型檔路徑
        $this->font_file = 'C:/windows/fonts/msjhl.ttc';

        //font_file_time 用於設定生成修改時間所用的字型檔路徑
        $this->font_file_time = 'C:/windows/fonts/mingliu.ttc';

        //pdf_final_dpi 設定最終pdf檔的DPI數值(寬*高)
        $this->pdf_final_dpi = array(96, 96);

        //pdf_final_resolution 設定最終pdf檔的解析度(寬*高)，若其中一個數值為0將自動依圖片比例調整(此設定將大幅影響運算效能)
        $this->pdf_final_resolution = array(794, 1123);

        //浮水印字體區

        //font_size 用於設定背景浮水印字體大小
        $this->font_size = 18;

        //font_size_time 用於設定修改時間的浮水印字體大小
        $this->font_size_time = 18;

    }

    public function index()
    {
        $original_pdf = APPPATH . 'public/pdf/bruh.pdf';
        $pdf_page = 4;
        $uid = 'EC0000001';
        $name = '維大利';

        $this->download_all_watermark($original_pdf, $pdf_page, $uid, $name);
    }

    public function download_all_watermark($original_pdf, $pdf_page, $uid, $name)
    {
        $a = $this->change_pdf_to_img_all($original_pdf, $pdf_page);

        if (!file_exists($this->watermark_path . $uid . '_' . $name . '.png')) {
            $this->create_watermark($a, $uid, $name);
        }

        $b = $this->watermark_all($a, $uid, $name);
        $c = $this->add_time($b);
        $d = $this->change_img_to_pdf($c);

        $this->download($d);
    }

    public function download_all_watermark_small()
    {
        $original_pdf = APPPATH . 'public/pdf/bruh.pdf';
        $pdf_page = 'ALL';
        $uid = 'EC0000002';
        $name = '維大利';

        $a = $this->change_pdf_to_img_all($original_pdf, $pdf_page);
        $b = $this->watermark_all_smallmark($a, $uid, $name);
        $c = $this->add_time($b);
        $d = $this->change_img_to_pdf($c);

        $this->download($d);
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

    public function download($source_info)
    {
        //source_info[0] = 檔案名稱，source_info[1] = 檔案位址
        force_download($source_info[0], file_get_contents($source_info[1]));
    }

    //TODO: 針對特定頁數轉換
    public function change_pdf_to_img_all($source_file, $page)
    {
        $source_pdf = $source_file;
        $pdf_page = $page;
        $img = new Imagick();
        $img->pingImage($source_pdf);

        if ($pdf_page === 'ALL') {
            $pdf_page = $img->getNumberImages();
        }

        for ($page = 0; $page < $pdf_page; $page++) {
            $img->setResolution($this->pdf_final_dpi[0], $this->pdf_final_dpi[1]); //DPI
            $img->readImage($source_pdf . '[' . $page . ']');
            $img->thumbnailImage($this->pdf_final_resolution[0], $this->pdf_final_resolution[1]); //Resolution
            $img->borderImage(new ImagickPixel("white"), 5, 5);
            $img->setImageCompressionQuality(100); //壓縮品質(100最高)

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

    public function watermark_all($image_name, $uid, $name)
    {
        //image_info與source_info格式相同
        //image_info為陣列，內容為rewriteimage.png
        $imgs_link = $image_name[0];
        $imgs_link_info = getimagesize($this->cache_path . $imgs_link);
        $imgs_link_width = $imgs_link_info[0];
        $imgs_link_height = $imgs_link_info[1];
        $watermark_image = $this->watermark_path . $uid . '_' . $name . '.png';

        $img = new Imagick();
        $img_watermark = new Imagick($watermark_image);
        $img->setCompressionQuality(100);
        // $img->setResolution(100, 100);

        foreach ($image_name as $num => $image) {
            $img->readImage($this->cache_path . $image);
            // $img->thumbnailImage($imgs_link_width, $imgs_link_height);
            $img->compositeImage($img_watermark, imagick::COMPOSITE_OVER, 0, 0);

            $img->writeImage($this->cache_path . 'result' . $num . '.png');
            $result_name[] = 'result' . $num . '.png';
            $result_link[] = $this->cache_path . 'result' . $num . '.png';
        }

        return array(
            $result_name, $result_link,
        );
    }

    public function watermark_all_smallmark($image_name, $uid, $name)
    {
        //使用小張浮水印重複貼上目標
        //image_name為陣列，內容為rewriteimage.png
        $imgs_link = $image_name[0];
        $imgs_link_info = getimagesize($this->cache_path . $imgs_link);
        $imgs_link_width = $imgs_link_info[0];
        $imgs_link_height = $imgs_link_info[1];
        $watermark_image = $this->watermark_path . $uid . '_' . $name . '.png';

        if (!file_exists($watermark_image)) {
            $this->create_watermark_small($uid, $name);
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
        // $img->setResolution(100, 100);

        foreach ($image_name as $num => $image) {
            $img->readImage($this->cache_path . $image);
            // $img->thumbnailImage($imgs_link_width, $imgs_link_height);

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

    //迴圈效能問題待釐清
    public function change_img_to_pdf($image_name)
    {
        $pdf = new Imagick();
        $images = $image_name;

        // foreach ($images as $key => $image) {
        //     if ($key === 0) {
        //         foreach ($image as $name) {
        //             $img = new Imagick();
        //             // $img->setResolution($this->pdf_final_dpi[0], $this->pdf_final_dpi[1]);
        //             $img->readImage($this->cache_path . $name);
        //             // $img->thumbnailImage($this->pdf_final_resolution[0], $this->pdf_final_dpi[1]);
        //             $pdf->addImage($img);
        //         }
        //     }
        // }

        foreach ($images[0] as $name) {
            $img = new Imagick();
            $img->readImage($this->cache_path . $name);
            $pdf->addImage($img);
        }

        $pdf->setImageFormat('pdf');
        $pdf->writeImages($this->cache_path . 'output.pdf', true);
        $result_name = 'output.pdf';
        $result_link = $this->cache_path . 'output.pdf';
        $pdf->clear();
        $pdf->destroy();

        return array($result_name, $result_link);
    }

    public function create_watermark($image_info, $uid, $name)
    {
        $image_link = $image_info[0];
        $arr_width_height = $this->get_width_height($this->cache_path . $image_link);
        $words_in_watermark = ' ' . $name;

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

    public function create_watermark_small($uid, $name)
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

    public function get_width_height($result_image)
    {
        $target_image = $result_image;
        $target_image_info = getimagesize($target_image);
        $target_image_width = $target_image_info[0];
        $target_image_height = $target_image_info[1];
        $arr_width_height = array($target_image_width, $target_image_height);
        return $arr_width_height;
    }

    //迴圈效能問題待釐清
    public function add_time($image_info)
    {
        $img = new Imagick($image_info[1][0]);
        $draw = new ImagickDraw();

        //set font
        $draw->setFontSize($this->font_size_time);
        $draw->setFont($this->font_file_time);
        $draw->setFillColor(new ImagickPixel('#8E8E8E'));
        $draw_text = date("Y-m-d H:i:s") . ' 修改';
        $width = $img->getImageWidth();
        $height = $img->getImageHeight();
        $horizontal_alignment = 'right';
        $vertical_alignment = 'top';
        $padding = 10;
        $metrics = $img->queryFontMetrics($draw, $draw_text);
        $text_width = $metrics['textWidth'];
        $text_height = $metrics['textHeight'];
        $x = ($horizontal_alignment === 'left') ? $padding : (($horizontal_alignment === 'right') ? ($width - ($padding + $text_width)) : ($width / 2));
        $y = ($vertical_alignment === 'top') ? $padding : (($vertical_alignment === 'bottom') ? ($height - $padding) : ($height / 2));

        foreach ($image_info as $num => $value) {
            if ($num === 1) {
                foreach ($value as $num => $image) {
                    $img->readImage($image);
                    $img->annotateImage($draw, $x, $y, 0, $draw_text);
                    $img->writeImage($this->cache_path . 'addedtime' . $num . '.png');
                    $result_name[] = 'addedtime' . $num . '.png';
                    $result_link[] = $this->cache_path . 'addedtime' . $num . '.png';
                }
            }
        }

        // foreach ($image_info[1] as $num => $image) {
        //     $img->readImage($image);
        //     $img->annotateImage($draw, $x, $y, 0, $draw_text);
        //     $img->writeImage($this->cache_path . 'addedtime' . $num . '.png');
        //     $result_name[] = 'addedtime' . $num . '.png';
        //     $result_link[] = $this->cache_path . 'addedtime' . $num . '.png';
        // }

        return array($result_name, $result_link);
    }

    // 已棄用(舊版，無法直接使用)
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

    // 已棄用(舊版，無法直接使用)
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

}
