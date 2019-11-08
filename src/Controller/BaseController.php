<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BaseRepository;
use App\Entity\Base;

class BaseController extends AbstractController
{
    CONST COLUMN_BASE_ID = 3;
    CONST COLUMN_SURNAME = 4;
    CONST COLUMN_FIRST_NAME = 5;
    CONST COLUMN_SI_NUMBER = 1;
    CONST COLUMN_CLUB = 9;

    /**
     * @Route("/admin/base/update", name="owp_admin_base_update")
     */
    public function update(BaseRepository $baseRepository): Response
    {
        $file = fopen('http://licences.ffcorientation.fr/licencesFFCO-OE2010.csv', 'r');
        $entityManager = $this->getDoctrine()->getManager();

        // Ignore first row
        fgetcsv($file, 0, ";");

        //Loop through the CSV rows.
        while (($row = fgetcsv($file, 0, ";")) !== FALSE) {
            $entity = $baseRepository->find($row[self::COLUMN_BASE_ID]);

            if( empty($entity)) {
                $entity = new Base();
                $entity->setId($row[self::COLUMN_BASE_ID]);
            }

            $entity
                ->setFirstName(utf8_encode($row[self::COLUMN_FIRST_NAME]))
                ->setSurname(utf8_encode($row[self::COLUMN_SURNAME]))
                ->setSI($row[self::COLUMN_SI_NUMBER])
                ->setClub($row[self::COLUMN_CLUB])
            ;

            $entityManager->persist($entity);
        }

        $entityManager->flush();

        return $this->redirectToRoute('owp_admin_base');
    }

    /**
     * @Route("/admin/base", name="owp_admin_base")
     */
    public function view(): Response
    {
        return $this->render('Base/view.html.twig', [

        ]);
    }
}
