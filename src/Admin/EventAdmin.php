<?php

// src/Admin/EventTypeAdmin.php

namespace App\Admin;

use App\Admin\AbstractNodeAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class EventAdmin extends AbstractNodeAdmin
{
    protected $baseRoutePattern  = 'event';
}
