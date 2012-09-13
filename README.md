# Controller prefix plugin for CakePHP #

`Controller name prefix' custom route plugin for CakePHP

[![Build Status](https://secure.travis-ci.org/k1LoW/controller_prefix.png?branch=2.0)](http://travis-ci.org/k1LoW/controller_prefix)

## Background ##

This custom route class prove controller name prefix route.

ex. /admin/users/edit => AdminUsersController::edit()

## Installation ##

Install 'ControllerPrefix' by [recipe.php](https://github.com/k1LoW/recipe) , and set `CakePlugin::load('ControllerPrefix');`

## Usage ##

Add the following code in routes.php

    App::uses('ControllerPrefixRoute', 'ControllerPrefix.Routing/Route');
    Router::connect('/admin/:controller/:action/*',
                    array('controllerPrefix' => 'admin'), array('routeClass' => 'ControllerPrefixRoute'));

## License ##

under MIT Lisence
