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
            $success = $newrole->save();
            $this->view->success = $success;
            if ($success) {
                $this->view->msg = "<h6 class='alert alert-success w-75 container text-center'>Added Successfully</h6>";
            } else {
                $this->view->msg = "<h6 class='alert alert-danger w-75 container text-center'>Something went wrong</h6>";
            }
        }
    }



    public function addComponentAction()
    {
        $request = new Request();
        $dir    = APP_PATH . '/controllers';
        $files = scandir($dir, 1);
        $controllers = array();
        foreach ($files as $key => $value) {
            $explode  = explode('Controller', $value);
            array_push($controllers, strtolower($explode[0]));
        }
        $this->view->controllers = array_diff($controllers, array('.', '..'));


        if (true === $request->isPost()) {
            $this->view->post = $request->getPost();
            $component = new Components();
            $component->assign(
                $request->getPost(),
                [
                    'component'
                ]
            );
            $success = $component->save();
            $this->view->success = $success;
            if ($success) {
                $this->view->msg = "<h6 class='alert alert-success w-75 container text-center'>Added Successfully</h6>";
            } else {
                $this->view->msg = "<h6 class='alert alert-danger w-75 container text-center'>Something went wrong</h6>";
            }
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

            echo json_encode($actions);
            die;
        }
    }

    public function dataAction()
    {

        $request = new Request();

        if ($request->isPost()) {
            $role = $request->getPost('roles');
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
                $aclFile = APP_PATH . '/security/acl.cache';

                if ($success) {

                    if (true === is_file($aclFile)) {

                        $acl = new Memory();

                        $permissions = Permissions::find();

                        foreach ($permissions as $permission) {

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

        $this->view->permissions = Permissions::find();
    }

    public function deleteAction()
    {
        $permission = Permissions::find($this->request->get('id'));
        print_r($permission[0]->id);
        // die;
        $success = $permission->delete();
        $aclFile = APP_PATH . '/security/acl.cache';
        if ($success) {

            if (true === is_file($aclFile)) {

                $acl = new Memory();

                $permissions = Permissions::find();

                foreach ($permissions as $permission) {

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
                $this->response->redirect('acl/data?role=admin');
            }
        }
    }
}
