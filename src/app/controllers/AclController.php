<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;
use Phalcon\Acl\Role;
use Phalcon\Acl\Adapter\Memory;



class AclController extends Controller
{
    public function indexAction()
    {
        echo 'ads';
    }
    public function addRoleAction()
    {
        $request = new Request();

        if (true === $request->isPost()) {
            $newrole = new Roles();
            $newrole->assign(
                $request->getPost(),
                [
                    'role'
                ]
            );
            $newrole->save();
        }
    }



    public function addComponentAction()
    {
        $request = new Request();
        $dir    = APP_PATH . '/controllers';
        $files = scandir($dir, 1);

        // print_r($files);
        $controllers = array();
        foreach ($files as $key => $value) {
            $explode  = explode('Controller', $value);
            array_push($controllers, $explode[0]);
        }
        $this->view->controllers = array_diff($controllers, array('.', '..')); // explode('Controller', $files[0]);


        if (true === $request->isPost()) {
            $this->view->post = $request->getPost();
            $component = new Components();
            $component->assign(
                $request->getPost(),
                [
                    'component'
                ]
            );
            $component->save();
        }
    }

    public function allowAction()
    {

        $this->view->roles = Roles::find();
        $this->view->components  = Components::find();
        if ($this->request->isPost('action')) {

            $controller   = $this->request->getPost('controller');
            $class_methods = get_class_methods($controller . 'Controller');
            echo json_encode($class_methods);
            die;
        }
    }

    public function dataAction()
    {
        $request = new Request();
        print_r($request->getPost());

        if ($request->isPost()) {
            $role = $request->getPost('role');
            $component  = $request->getPost('component');
            $action  = $request->getPost('action');
            $this->view->allow = $request->getPost();
            $permission = Permissions::query()
                ->where("role = :role:")
                ->andWhere("component = :component:")
                ->andWhere("action = :action:")
                ->bind(
                    [
                        'role' => $role,
                        'component'  => $component,
                        'action' => $action,
                    ]
                )
                ->execute();

            // print_r($permission);

            if (count($permission) < 1) {
                $permission = new Permissions();
                $permission->assign(
                    $request->getPost(),
                    [
                        'role',
                        'component',
                        'action'
                    ]
                );
                $success = $permission->save();
                echo "da";
                // print_r($permission);
            }
        }
    }
}
