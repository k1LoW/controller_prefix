<?php
class AdminRoute extends CakeRoute {

    /**
     * parse
     * description
     *
     * @param $arg
     * @return
     */
    function parse($url){
        if (preg_match('#^/admin/([^/]+)/?#', $url, $matches)) {
            $c = 'admin/' . $matches[1];
            if (preg_match('#^/' . $c . '(/?)([^/]*)(/?)([^/]*)#', $url, $matches)) {
                $action = $matches[2];
                if ($matches[1] === '') {
                    $url .= '/';
                }
                if ($matches[2] === '') {
                    $url .= 'index';
                }
            }
        }
        $route = parent::parse($url);
        if (is_array($route)) {
            if ($route['controllerPrefix'] === 'admin') {
                $route['controller'] = 'admin_' . $route['controller'];
            }
        }
        return $route;
    }

    /**
     * match
     * description
     *
     * @param $arg
     * @return
     */
    function match($url){
        if (preg_match('/^admin_/', $url['controller'])) {
            $instance =& Router::getInstance();
            $separator = $instance->named['separator'];
            $url['controller'] = preg_replace('/^admin_/', '', $url['controller']);

            $u = '/admin/' . $url['controller'];

            if ($url['action'] !== 'index') {
                 $u .= '/' . $url['action'];
            }

            unset($url['controller']);
            unset($url['action']);
            unset($url['plugin']);
            unset($url['prefix']);

            foreach ($url as $key => $value) {
                if (is_numeric($key)) {
                    $u .= '/' . $value;
                } else {
                    $u .= '/' . $key . $separator . $value;
                }
            }
            return $u;
        }
    }
  }