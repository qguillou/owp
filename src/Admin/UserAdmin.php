<?php

// src/Admin/EventTypeAdmin.php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Base;

final class UserAdmin extends AbstractAdmin
{
    protected $baseRoutePattern  = 'user';

    protected $datagridValues = [
        '_sort_by' => 'username',
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('username', TextType::class, [
                'disabled' => true
            ])
            ->add('base', EntityType::class, [
                'class' => Base::class,
                'choice_label' => 'id',
                'required' => false,
                'label' => 'N° de licence'
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Super administrateur' => 'ROLE_SUPER_ADMIN',
                    'Administrateur' => 'ROLE_ADMIN',
                    'Webmasteur' => 'ROLE_WEBMASTER',
                    'Licencié du club' => 'ROLE_MEMBER',
                    'Utilisateur' => 'ROLE_USER',
                ],
                'multiple' => true,
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
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
                    'edit' => ['template' => 'Administration/CRUD/list__action_edit.html.twig'],
                    'delete' => ['template' => 'Administration/CRUD/list__action_delete.html.twig'],
                ]
            ]);
    }
}
