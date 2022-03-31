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
            $rollarr = array(
                'role' => $request->getPost('roles'),
            );
            $newrole->assign(
                $rollarr,
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
            array_push($controllers, strtolower($explode[0]));
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
        $this->response->setHeader('Access-Control-Allow-Origin', '*');

        $this->view->roles = Roles::find();
        $this->view->components  = Components::find();
        if ($this->request->isPost('action')) {
            $controller   = $this->request->getPost('controller');
            $controller = strtolower($controller);
            $dir    = APP_PATH . '/views/' . $controller;
            $files = scandir($dir, 1);
            $actions = array();
            foreach ($files as $key => $value) {
                $explode  = explode('.phtml', $value);
                array_push($actions, $explode[0]);
            }
            $actions = array_diff($actions, array('.', '..'));
            // $class_methods = get_class_methods($controller . 'Controller');
            echo json_encode($actions);
            die;
        }
    }

    public function dataAction()
    {
        // die($this->request->getPost('role'));
        $request = new Request();
        print_r($request->getPost());

        if ($request->isPost()) {
            $role = $request->getPost('roles');
            // print_r($role);
            // die;
            $component  = $request->getPost('component');
            $action  = $request->getPost('action');
            $arr = array(
                'role' => $role,
                'component' => $component,
                'action' => $action,
            );
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


            if (count($permission) < 1) {
                $permission = new Permissions();
                $permission->assign(
                    $arr,
                    [
                        'role',
                        'component',
                        'action'
                    ]
                );

                $success = $permission->save();
                // echo $success;
                // die;
                $aclFile = APP_PATH . '/security/acl.cache';
                print_r($aclFile);
                if ($success) {
                    print_r('success');
                    if (true === is_file($aclFile)) {
                        print_r('success');
                        $acl = new Memory();
                        // $acl = unserialize(file_get_contents($aclFile));
                        $permissions = Permissions::find();
                        // print_r($permissions[0]->role);
                        foreach ($permissions as $permission) {
                            // print_r($permission->role);
                            $acl->addRole($permission->role);
                            if ($permission->action == "*") {
                                $acl->allow('admin', '*', "*");
                                continue;
                            }
                            $acl->addComponent(
                                $permission->component,
                                $permission->action
                            );
                            $acl->allow($permission->role, $permission->component, $permission->action);
                        }

                        file_put_contents(
                            $aclFile,
                            serialize($acl)
                        );
                    } else {
                        $acl = unserialize(file_get_contents($aclFile));
                    }
                }
            }
        }
    }
}
