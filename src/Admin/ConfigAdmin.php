<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class ConfigAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'configuration';
    protected $baseRouteName = 'configuration';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clear();
        $collection->add('list', 'config', [
            '_controller' => 'App\Controller\AdministrationController::configAction',
        ]);
    }
}
