<?php
// src/Command/UpdateFederalArchiveCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BaseRepository;

class UpdateFederalArchiveCommand extends Command
{
    protected static $defaultName = 'app:federale-archive:update';

    const COLUMN_BASE_ID = 3;
    const COLUMN_LAST_NAME = 4;
    const COLUMN_FIRST_NAME = 5;
    const COLUMN_SI_NUMBER = 1;
    const COLUMN_CLUB = 9;

    private $em;
    private $baseRepository;

    public function __construct(EntityManagerInterface $em, BaseRepository $baseRepository, $name = null)
    {
        parent::__construct($name);

        $this->em = $em;
        $this->baseRepository = $baseRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Mise à jour de l\'archive fédérale')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Cette commande vous permet de mettre à jour la base de données avec l\'archive fédérale datée de ce jour.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Mise à jour de l\'archive fédérale');

        $output->writeln('Téléchargement de l\'archive fédérale du jour');
        $file = fopen('http://licences.ffcorientation.fr/licencesFFCO-OE2010.csv', 'r');

        $output->writeln('Import dans la base de données');
        $numberInsert = 0;
        $numberUpdate = 0;
        fgetcsv($file, 0, ";");
        while (($row = fgetcsv($file, 0, ";")) !== false) {
            $entity = $this->baseRepository->find($row[self::COLUMN_BASE_ID]);

            if (empty($entity)) {
                $entity = new Base();
                $entity->setId($row[self::COLUMN_BASE_ID]);
                $numberInsert++;
            }
            else {
                $numberUpdate++;
            }

            $entity
                ->setFirstName(utf8_encode($row[self::COLUMN_FIRST_NAME]))
                ->setLastName(utf8_encode($row[self::COLUMN_LAST_NAME]))
                ->setSI($row[self::COLUMN_SI_NUMBER])
                ->setClub($row[self::COLUMN_CLUB])
            ;

            $this->em->persist($entity);
        }

        $this->em->flush();
        $output->writeln([
            'Import terminé',
            'Insertions : ' . $numberInsert,
            'Mise à jour : ' . $numberUpdate,
        ]);
    }
}
