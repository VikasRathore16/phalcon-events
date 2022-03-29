<?php

namespace App\Components;

use Phalcon\Escaper;

class Myescaper
{
    public $escaper;
    public function __construct()
    {
        $this->escaper =  new Escaper();
    }
    public function santize($request)
    {
        $arr = array();
        foreach ($request as $key => $value) {

            $arr[$key] = $this->escaper->escapeHtml($value);

            if ($value == '') {
                // $eventsManager = $this->di->get('eventsManager');
                // $eventsManager->fire('notification:beforesend', $this);
                $arr[$key] = '';
            }
        }

        return $arr;
    }
}
