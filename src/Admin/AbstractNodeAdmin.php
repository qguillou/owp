<?php

// src/Admin/EventTypeAdmin.php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

abstract class AbstractNodeAdmin extends AbstractAdmin
{
    const LABEL = 'title';

    protected $datagridValues = [
        '_sort_by' => self::LABEL,
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Meta data', ['class' => 'col-md-3'])
                ->add('createAt', DateTimeType::class, ['disabled' => true])
                ->add('updateAt', DateTimeType::class, ['disabled' => true])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add(self::LABEL);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier(self::LABEL)
        ->add('createAt', 'datetime', array('format' => 'd/m/Y H:i'))
        ->add('createBy.username')
        ->add('updateAt', 'datetime', array('format' => 'd/m/Y H:i'))
        ->add('updateBy.username')
        ->add('_action', null, [
            'actions' => [
                'show' => ['template' => 'Administration/CRUD/list__action_show.html.twig'],
                'edit' => ['template' => 'Administration/CRUD/list__action_edit.html.twig'],
                'delete' => ['template' => 'Administration/CRUD/list__action_delete.html.twig'],
            ]
        ]);
    }
}
