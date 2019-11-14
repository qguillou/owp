<?php

// src/Admin/EventTypeAdmin.php

namespace App\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Route\RouteCollection;

final class NewsAdmin extends AbstractNodeAdmin
{
    protected $baseRoutePattern  = 'news';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Informations générales', ['class' => 'text-bold col-12 col-lg-9'])
                ->add(self::LABEL, TextType::class)
                ->add('content', CKEditorType::class, array('config_name' => 'default'))
                ->add('promote', CheckboxType::class, ['required' => false])
            ->end()
        ;

        parent::configureFormFields($formMapper);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('show', $this->getRouterIdParameter(), [
                '_controller' => 'App\Controller\NewsController::show',
            ]
        );
    }
}
