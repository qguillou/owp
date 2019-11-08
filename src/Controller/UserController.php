<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @Route("/profile/delete/{id}", name="owp_user_delete")
     */
    public function delete(User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $current_user = $this->getUser();

        if ($user->getId() === $current_user->getId() || $current_user->isGranted('ROLE_ADMIN')) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('owp_common_homepage');
    }
}
