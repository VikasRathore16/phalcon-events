<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;
use Phalcon\Mvc\Controller;


class SecureController extends Controller
{
    public function indexAction()
    {
        $aclFile = APP_PATH . '/security/acl.cache';

        if (true !== is_file($aclFile)) {
            $acl = new Memory();

            $acl->addRole('admin');


            $acl->addComponent(
                'index',
                [
                    'index',
                ]
            );

            $acl->allow('admin', '*', '*');
            // $acl->deny('guest', '*', '*');

            file_put_contents(
                $aclFile,
                serialize($acl)
            );
        } else {
            $acl = unserialize(file_get_contents($aclFile));
        }


        if (true == $acl->isallowed('manager', 'index', 'index')) {
            echo "Access granted";
        } else {
            echo "Access denied";
        }
    }

    public function eventAction()
    {
        // $eventsManager = $this->di->get('EventsManager');
        // $eventsManager->fire('application:beforeHandleRequest', new \Phalcon\Mvc\Application);
    }
}
