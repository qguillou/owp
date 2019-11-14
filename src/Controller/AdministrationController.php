<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AdministrationController extends CRUDController
{
    public function listAction()
    {
        return new Response();
    }

    /**
     * @Route("/admin/configuration/config", name="owp_admin_configuration_config")
     */
    public function configAction(Request $request)
    {
        $env = file_get_contents(__DIR__.'/../../.env.local');

        $name = array();
        preg_match('/APP_NAME="([a-zA-Z0-9_ ]*)"/', $env, $name);

        $values = [
            'name' => $name[1]
        ];

        $form = $this->createFormBuilder($values)
            ->add('name', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $env = preg_replace('/' . $values['name'] . '/', $data['name'], $env);
            file_put_contents(__DIR__.'/../../.env.local', $env);
        }

        return $this->render('Administration/CRUD/configuration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
