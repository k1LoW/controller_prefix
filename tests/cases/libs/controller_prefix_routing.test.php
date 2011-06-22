<?php
App::import('Core', 'Dispatcher');
App::import('Lib', 'ControllerPrefix.ControllerPrefixRoute');

class ControllerPrefixRoutingTestCase extends CakeTestCase {

    /**
     * testParse
     *
     */
    function testParse(){
        Router::connect('/admin/:controller/:action/*',
                        array('controllerPrefix' => 'admin'), array('routeClass' => 'ControllerPrefixRoute'));

        $Dispatcher =& new Dispatcher();

        $params = $Dispatcher->parseParams('/users/');
        $this->assertIdentical('users', $params['controller']);
        $this->assertIdentical('index', $params['action']);
        $this->assertIdentical(array(), $params['pass']);
        $this->assertIdentical(array(), $params['named']);

        $params = $Dispatcher->parseParams('/admin/users/');
        $this->assertIdentical('admin_users', $params['controller']);
        $this->assertIdentical('index', $params['action']);
        $this->assertIdentical(array(), $params['pass']);
        $this->assertIdentical(array(), $params['named']);

        $params = $Dispatcher->parseParams('/admin/users/edit/1');
        $this->assertIdentical('admin_users', $params['controller']);
        $this->assertIdentical('edit', $params['action']);
        $this->assertIdentical(array('0' => '1'), $params['pass']);
        $this->assertIdentical(array(), $params['named']);

        $params = $Dispatcher->parseParams('/admin/admin/edit/1');
        $this->assertIdentical('admin_admin', $params['controller']);
        $this->assertIdentical('edit', $params['action']);
        $this->assertIdentical(array('0' => '1'), $params['pass']);
        $this->assertIdentical(array(), $params['named']);

        $params = $Dispatcher->parseParams('/admin/users/edit/1/page:2');
        $this->assertIdentical('admin_users', $params['controller']);
        $this->assertIdentical('edit', $params['action']);
        $this->assertIdentical(array('0' => '1'), $params['pass']);
        $this->assertIdentical(array('page' => '2'), $params['named']);

        $params = $Dispatcher->parseParams('/admin/users');
        $this->assertIdentical('admin_users', $params['controller']);
        $this->assertIdentical('index', $params['action']);

        $params = $Dispatcher->parseParams('/admin/users/page:2');
        $this->assertIdentical('admin_users', $params['controller']);
        $this->assertIdentical('index', $params['action']);
        $this->assertIdentical(array('page' => '2'), $params['named']);

        $params = $Dispatcher->parseParams('/admin/users/page:2');
        $this->assertIdentical('admin_users', $params['controller']);
        $this->assertIdentical('index', $params['action']);
        $this->assertIdentical(array('page' => '2'), $params['named']);

        $params = $Dispatcher->parseParams('/admin/users/page:2/sort:3');
        $this->assertIdentical('admin_users', $params['controller']);
        $this->assertIdentical('index', $params['action']);
        $this->assertIdentical(array('page' => '2', 'sort' => '3'), $params['named']);
    }

    /**
     * testMatch
     *
     * @return
     */
    function testMatch(){
        $url = Router::url(array('controller' => 'admin_users', 'action' => 'edit',2));
        $this->assertIdentical('/admin/users/edit/2', $url);
    }
}
