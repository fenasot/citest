<?php
function show()
{
    echo "test test";
}

show();

class Cart
{

    public $abc;
    public $HTTP_RAW_POST_DATA;
    public function __construct($pia)
    {
        $this->abc = $pia;
    }
    public function echo () {
        echo $HTTP_RAW_POST_DATA;
        echo "aaa" . $abc;
    }

}

$cal = new Cart(123456);
$cal->echo();
$this->cal->echo();
