<?php

// src/Admin/EventTypeAdmin.php

namespace App\Admin;

use App\Admin\AbstractNodeAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Entity\EventType;
use App\Entity\Event;

final class EventAdmin extends AbstractNodeAdmin
{
    protected $baseRoutePattern  = 'event';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Main informations', ['class' => 'text-bold col-md-9'])
                ->add(self::LABEL, TextType::class)
                ->add('content', CKEditorType::class, ['config_name' => 'default', 'required' => false])
                ->add('dateBegin', DateTimeType::class, array(
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'form-control input-inline datetimepicker',
                        'data-provide' => 'datetimepicker',
                        'html5' => false,
                    ],
                ))
                ->add('dateEnd', DateTimeType::class, array(
                    'required' => false,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'form-control input-inline datetimepicker',
                        'data-provide' => 'datetimepicker',
                        'html5' => false,
                    ],
                ))
                ->add('eventType', EntityType::class, [
                    'class' => EventType::class,
                    'choice_label' => 'label',
                ])
            ->end()
        ;

        parent::configureFormFields($formMapper);

        $formMapper
            ->with('location', ['class' => 'col-md-9'])
                ->add('locationTitle', TextType::class, ['required' => false])
                ->add('locationInformation', CKEditorType::class, ['config_name' => 'default', 'required' => false])
                ->add('latitude', NumberType::class, ['required' => false])
                ->add('longitude', NumberType::class, ['required' => false])
            ->end()
        ;

        /*$formMapper
            ->with('link events', ['class' => 'col-md-9'])
                ->add('linkEvents', EntityType::class, [
                    'class' => Event::class,
                    'choice_label' => 'title',
                    'multiple' => true,
                ])
            ->end()
        ;*/
    }
}
