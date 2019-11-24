<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="owp_homepage")
     */
    public function index(): Response
    {
        return $this->render('Homepage/homepage.html.twig', [
            'news' => $this->has('service.news') ? $this->get('service.news')->getBy() : [],
            'events' => $this->has('service.event') ? $this->get('service.event')->getBy() : [],
        ]);
    }
}
