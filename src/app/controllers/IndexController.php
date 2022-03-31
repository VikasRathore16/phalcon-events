<?php

use Phalcon\Mvc\Controller;


class IndexController extends Controller
{
    public function indexAction()
    {
    }

    public function productListAction()
    {
        $this->view->products = Products::find();
    }

    public function addProductAction()
    {
        if ($this->request->isPost()) {
            $newProduct = new Products();
            $myescaper = new App\Components\Myescaper();
            $myescaper = $myescaper->santize($this->request->getPost());
            $this->view->post = $this->request->getPost();
            $this->view->product = $myescaper;
            
            $newProduct->assign(
                $myescaper,
                [
                    'product_name',
                    'description',
                    'tags',
                    'price',
                    'stocks'
                ]
            );

            $newProduct->save();
            $eventsManager = $this->di->get('EventsManager');
            $settings = Settings::find(1);
            $this->view->event =   $eventsManager->fire('notification:beforesend', $newProduct, $settings);
       
            $success = $this->view->event->save();
            if ($success) {
                $this->view->msg = "<h6 class='alert alert-success w-75 container text-center'>Added Successfully</h6>";
            } else {
                $this->view->msg = "<h6 class='alert alert-danger w-75 container text-center'>Something went wrong</h6>";
            }
        }
    }

    public function orderListAction()
    {
        $this->view->orders = Orders::find();
    }

    public function addOrderAction()
    {
        $this->view->products = Products::find();

        if ($this->request->isPost()) {
            $newOrder = new Orders();
            $myescaper = new App\Components\Myescaper();
            $myescaper = $myescaper->santize($this->request->getPost());
            $this->view->post = $this->request->getPost();
            $this->view->order = $myescaper;
            // die();
            $newOrder->assign(
                $myescaper,
                [
                    'customer_name',
                    'customer_address',
                    'zipcode',
                    'product',
                    'quantity'
                ]
            );
            $this->view->order = $newOrder;
            $newOrder->save();
            $eventsManager = $this->di->get('EventsManager');
            $settings = Settings::find(1);
            $this->view->event =   $eventsManager->fire('notification:beforesend', $newOrder, $settings);
            $success = $this->view->event->save();
            if ($success) {
                $this->view->msg = "<h6 class='alert alert-success w-75 container text-center'>Added Successfully</h6>";
            } else {
                $this->view->msg = "<h6 class='alert alert-danger w-75 container text-center'>Something went wrong</h6>";
            }
        }
    }

    public function settingsAction()
    {
        if ($this->request->isPost()) {
            $arr = $this->request->getPost();
            $settings = Settings::find(1);
            $settings[0]->title_optimization = $arr['title'];
            $settings[0]->default_price = $arr['default_price'];
            $settings[0]->default_stock = $arr['default_stock'];
            $settings[0]->default_zip = $arr['default_zipcode'];
            $success = $settings[0]->save();
            if ($success) {
                $this->view->msg = "<h6 class='alert alert-success w-75 container text-center'>Upated Successfully</h6>";
            }
            if (!$success) {
                $this->view->msg = "<h6 class='alert alert-danger w-75 container text-center'>Something went wrong</h6>";
            }
        }
    }
}
