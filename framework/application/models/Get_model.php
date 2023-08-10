<?php

class Get_model extends CI_Model
{
    public function get_json()
    {
        $json = file_get_contents(base_url('application/public/json/score.json'));
        $jsondecode = json_decode($json);
        var_dump( $jsondecode);
    }
}
