<?php
App::uses('CakeRoute', 'Routing/Route');
App::uses('Router', 'Routing');
App::uses('ControllerPrefixRoute', 'ControllerPrefix.Routing/Route');

class ControllerPrefixRoutingTestCase extends CakeTestCase {

    /**
     * testParse
     *
     */
    function testParse(){
        $route = new ControllerPrefixRoute('/admin/:controller/:action/*',
                                           array('controllerPrefix' => 'admin')
                                           );

        $result = $route->parse('/admin/users/');
        $this->assertIdentical('admin_users', $result['controller']);
        $this->assertIdentical('index', $result['action']);
        $this->assertIdentical(array(), $result['pass']);
        $this->assertIdentical(array(), $result['named']);

        $result = $route->parse('/admin/users/edit/1');
        $this->assertIdentical('admin_users', $result['controller']);
        $this->assertIdentical('edit', $result['action']);
        $this->assertIdentical(array('0' => '1'), $result['pass']);
        $this->assertIdentical(array(), $result['named']);

        $result = $route->parse('/admin/admin/edit/1');
        $this->assertIdentical('admin_admin', $result['controller']);
        $this->assertIdentical('edit', $result['action']);
        $this->assertIdentical(array('0' => '1'), $result['pass']);
        $this->assertIdentical(array(), $result['named']);

        $result = $route->parse('/admin/users/edit/1/page:2');
        $this->assertIdentical('admin_users', $result['controller']);
        $this->assertIdentical('edit', $result['action']);
        $this->assertIdentical(array('0' => '1'), $result['pass']);
        $this->assertIdentical(array('page' => '2'), $result['named']);

        $result = $route->parse('/admin/users');
        $this->assertIdentical('admin_users', $result['controller']);
        $this->assertIdentical('index', $result['action']);

        $result = $route->parse('/admin/users/page:2');
        $this->assertIdentical('admin_users', $result['controller']);
        $this->assertIdentical('index', $result['action']);
        $this->assertIdentical(array('page' => '2'), $result['named']);

        $result = $route->parse('/admin/users/page:2');
        $this->assertIdentical('admin_users', $result['controller']);
        $this->assertIdentical('index', $result['action']);
        $this->assertIdentical(array('page' => '2'), $result['named']);

        $result = $route->parse('/admin/users/page:2/sort:3');
        $this->assertIdentical('admin_users', $result['controller']);
        $this->assertIdentical('index', $result['action']);
        $this->assertIdentical(array('page' => '2', 'sort' => '3'), $result['named']);
    }

    /**
     * testMatch
     *
     * @return
     */
    function testMatch(){
        $route = new ControllerPrefixRoute('/admin/:controller/:action/*',
                                           array('controllerPrefix' => 'admin')
                                           );
        $result = $route->match(array('controller' => 'admin_users', 'action' => 'edit',2));
        $this->assertIdentical('/admin/users/edit/2', $result);
    }

    /**
     * testParseNotAdmin
     *
     */
    function testParseNotAdmin(){
        $route = new ControllerPrefixRoute('/not_admin/:controller/:action/*',
                                           array('controllerPrefix' => 'not_admin')
                                           );

        $result = $route->parse('/not_admin/users/');
        $this->assertIdentical('not_admin_users', $result['controller']);
        $this->assertIdentical('index', $result['action']);
        $this->assertIdentical(array(), $result['pass']);
        $this->assertIdentical(array(), $result['named']);

        $result = $route->parse('/not_admin/users/edit/1');
        $this->assertIdentical('not_admin_users', $result['controller']);
        $this->assertIdentical('edit', $result['action']);
        $this->assertIdentical(array('0' => '1'), $result['pass']);
        $this->assertIdentical(array(), $result['named']);

        $result = $route->parse('/not_admin/not_admin/edit/1');
        $this->assertIdentical('not_admin_not_admin', $result['controller']);
        $this->assertIdentical('edit', $result['action']);
        $this->assertIdentical(array('0' => '1'), $result['pass']);
        $this->assertIdentical(array(), $result['named']);

        $result = $route->parse('/not_admin/users/edit/1/page:2');
        $this->assertIdentical('not_admin_users', $result['controller']);
        $this->assertIdentical('edit', $result['action']);
        $this->assertIdentical(array('0' => '1'), $result['pass']);
        $this->assertIdentical(array('page' => '2'), $result['named']);

        $result = $route->parse('/not_admin/users');
        $this->assertIdentical('not_admin_users', $result['controller']);
        $this->assertIdentical('index', $result['action']);

        $result = $route->parse('/not_admin/users/page:2');
        $this->assertIdentical('not_admin_users', $result['controller']);
        $this->assertIdentical('index', $result['action']);
        $this->assertIdentical(array('page' => '2'), $result['named']);

        $result = $route->parse('/not_admin/users/page:2');
        $this->assertIdentical('not_admin_users', $result['controller']);
        $this->assertIdentical('index', $result['action']);
        $this->assertIdentical(array('page' => '2'), $result['named']);

        $result = $route->parse('/not_admin/users/page:2/sort:3');
        $this->assertIdentical('not_admin_users', $result['controller']);
        $this->assertIdentical('index', $result['action']);
        $this->assertIdentical(array('page' => '2', 'sort' => '3'), $result['named']);
    }

    /**
     * testNotAdminMatch
     *
     * @return
     */
    function testNotAdminMatch(){
        $route = new ControllerPrefixRoute('/not_admin/:controller/:action/*',
                                           array('controllerPrefix' => 'not_admin')
                                           );
        $result = $route->match(array('controller' => 'not_admin_users', 'action' => 'edit',2));
        $this->assertIdentical('/not_admin/users/edit/2', $result);
    }
}
