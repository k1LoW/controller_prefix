<?php
App::uses('CakeRoute', 'Routing/Route');
class ControllerPrefixRoute extends CakeRoute {

    /**
     * parse
     *
     * @param $url
     * @return
     */
    function parse($url){
        if (preg_match('#^/' . $this->defaults['controllerPrefix'] . '/([^/:]+)/(.+)#', $url, $matches)) {
            $c = $this->defaults['controllerPrefix'] . '/' . $matches[1];
            if (preg_match('#^/' . $c . '(/?)([^/]*)/?(.*)#', $url, $matches)) {
                if ($matches[1] === '') {
                    $url .= '/';
                }
                if ($matches[2] === '') {
                    $url .= 'index';
                }
                if (strpos($matches[2], ':')) {
                    unset($matches[0]);
                    unset($matches[1]);
                    $url = '/' . $c . '/index/' . implode('/', $matches);
                }
            }
        } else if (preg_match('#^/' . $this->defaults['controllerPrefix'] . '/([^/:]+)/?$#', $url, $matches)) {
            $url = '/' . $this->defaults['controllerPrefix'] . '/' . $matches[1] . '/index';
        }
        $route = parent::parse($url);
        if (is_array($route)) {
                $route['controller'] = $this->defaults['controllerPrefix'] . '_' . $route['controller'];
        }
        return $route;
    }

    /**
     * match
     *
     * @param $url
     * @return
     */
    function match($url){
        if (preg_match('/^' . $this->defaults['controllerPrefix'] . '_/', $url['controller'])) {

            // backup defaults
            $defaultsBackup = $this->defaults;

            // remove controllerPrefix from controller
            $url['controller'] = preg_replace('/^' . $this->defaults['controllerPrefix'] . '_/', '', $url['controller']);

            $this->default['prefix'] = $this->defaults['controllerPrefix'];
            unset($this->defaults['controllerPrefix']);

            $result = parent::match($url);

            // restore defaults
            $this->defaults = $defaultsBackup;

            return $result;
        }
    }
}
