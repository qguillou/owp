<?php

// src/Admin/EventTypeAdmin.php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Route\RouteCollection;

abstract class AbstractEntityAdmin extends AbstractAdmin
{
    const LABEL = 'label';

    protected $datagridValues = [
        '_sort_by' => self::LABEL,
        '_per_page' => 50
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add(self::LABEL, TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add(self::LABEL);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier(self::LABEL)
        ->add('createAt', 'datetime', [
            'format' => 'd/m/Y H:i',
            'header_class' => 'd-none d-lg-table-cell',
        ])
        ->add('createBy.username', 'text', [
            'header_class' => 'd-none d-lg-table-cell',
        ])
        ->add('updateAt', 'datetime', [
            'format' => 'd/m/Y H:i',
            'header_class' => 'd-none d-lg-table-cell',
        ])
        ->add('updateBy.username', 'text', [
            'header_class' => 'd-none d-lg-table-cell',
        ])
        ->add('_action', null, [
            'actions' => [
                'edit' => ['template' => 'Administration/CRUD/list__action_edit.html.twig'],
                'delete' => ['template' => 'Administration/CRUD/list__action_delete.html.twig'],
            ]
        ]);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
    }
}
