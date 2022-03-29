<?php

namespace App\Listeners;

use Phalcon\Di\Injectable;
use Phalcon\Events\Event;

class NotificationListeners extends Injectable
{
    public function afterSend(Event $event, \App\Components\DateHelper $components)
    {
        $logger = $this->di->get('logger');
        $logger->info('After notification');
    }

    public function beforeSend(Event $event, $addarr, $settings)
    {
        $logger = $this->di->get('logger');
        // $logger->info("Before notification. ".json_encode($addarr)."");
        if ($addarr->customer_name != '') {
            $logger->info('Before notification. Order Added');
        }
        if ($addarr->product_name != '') {
            $logger->info('Before notification. Product Added');
        }

        if ($addarr->price == '') {
            $addarr->price = $settings[0]->default_price;
        }
        if ($addarr->stocks == '') {
            $addarr->stocks = $settings[0]->default_stock;
        }
        if ($settings[0]->title_optimization == 'Y') {
            $addarr->product_name = "$addarr->product_name" . "$addarr->tags";
        }
        if ($addarr->zipcode == '') {
            $addarr->zipcode = $settings[0]->default_zipcode;
        }
        return $addarr;
    }
}
