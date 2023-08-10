<?php $json = file_get_contents(base_url('application/public/json/score.json'));
    $jsondecode = json_decode($json);
    var_dump($jsondecode->score[0]);

    foreach($jsondecode->score[0]->data as $key){
        echo $key->x.'<br>  ';
    }

    //echo implode( $jsondecode->score[0]);