<?php

// src/Admin/EventTypeAdmin.php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class UserAdmin extends AbstractAdmin
{

    protected $datagridValues = [
        '_sort_by' => 'username',
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('username', TextType::class, [
                'disabled' => true
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Super administrateur' => 'ROLE_SUPER_ADMIN',
                    'Administrateur' => 'ROLE_ADMIN',
                    'Webmasteur' => 'ROLE_WEBMASTER',
                    'Utilisateur' => 'ROLE_USER',
                ],
                'multiple' => true,
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('username');
        $datagridMapper->add('email');
        $datagridMapper->add('roles');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->addIdentifier('email')
            ->add('roles')
            ->add('lastLogin', 'datetime', array('format' => 'd/m/Y H:i'))
            ->add('_action', null, [
                'actions' => [
                    'show' => ['template' => 'Administration/CRUD/list__action_show.html.twig'],
                    'edit' => ['template' => 'Administration/CRUD/list__action_edit.html.twig'],
                    'delete' => ['template' => 'Administration/CRUD/list__action_delete.html.twig'],
                ]
            ]);
    }
}
