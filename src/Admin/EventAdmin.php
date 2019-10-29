<?php

// src/Admin/EventTypeAdmin.php

namespace App\Admin;

use App\Admin\AbstractNodeAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Entity\EventType;

final class EventAdmin extends AbstractNodeAdmin
{
    protected $baseRoutePattern  = 'event';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Main information', ['class' => 'col-md-9'])
                ->add(self::LABEL, TextType::class)
                ->add('content', CKEditorType::class, ['config_name' => 'default', 'required' => false])
                ->add('dateBegin', DateTimeType::class)
                ->add('dateEnd', DateTimeType::class, ['required' => false])
                ->add('eventType', EntityType::class, [
                    'class' => EventType::class,
                    'choice_label' => 'label',
                ])
            ->end()
        ;

        parent::configureFormFields($formMapper);
    }
}
