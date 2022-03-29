<?php

use Phalcon\Mvc\Controller;


class TestController extends Controller
{
    public function indexAction()
    {
        echo "he;;p";
        print_r($this->config->get('app')->get('name'));
    }
    public function loaderAction()
    {
        $date = new \App\Components\DateHelper();
        echo $date->getDate();
    }
    public function eventAction()
    {
        $date = new \App\Components\DateHelper();
        echo $date->getDate();
        die;
    }
}
