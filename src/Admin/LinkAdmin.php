<?php

// src/Admin/EventTypeAdmin.php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class LinkAdmin extends AbstractOWPAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper
            ->add('label', TextType::class)
            ->add('link', TextType::class)
            ->add('description', TextareaType::class, ['required' => false]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('label');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('label');

        parent::configureListFields($listMapper);
    }
}
