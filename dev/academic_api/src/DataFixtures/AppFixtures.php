<?php

namespace App\DataFixtures;

use App\Entity\Cours;
use App\Entity\Enseignant;
use App\Entity\Programme;
use App\Entity\Reference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $enseignants = [];
        for ($i = 0; $i < 25; $i++) {
            $enseignant = (new Enseignant())
                ->setPrenom($faker->firstName)
                ->setNom($faker->lastName)
                ->setPoste($faker->randomElement(['Professeur', 'Assistant', 'Maitre de conferences', 'Vacataire']));
            $manager->persist($enseignant);
            $enseignants[] = $enseignant;
        }

        $programmes = [];
        for ($i = 0; $i < 5; $i++) {
            $programme = new Programme();
            $programme->setTitre($faker->sentence(3));
            if ($faker->boolean(60)) {
                $programme->setSousTitre($faker->sentence(4));
            }
            $programme->setDescription($faker->paragraph(3));
            $programme->setNombreDeSemestres($faker->numberBetween(2, 10));
            $programme->setNombreDeCredits($faker->numberBetween(60, 180));
            $programme->setEnseignant($faker->randomElement($enseignants));
            if ($i > 0 && $faker->boolean(40)) {
                $programme->setProgramme($programmes[$faker->numberBetween(0, $i - 1)]);
            }
            $manager->persist($programme);
            $programmes[] = $programme;
        }

        $cours = [];
        for ($i = 0; $i < 50; $i++) {
            $cour = new Cours();
            $cour->setNom($faker->sentence(4));
            $cour->setNombreDeCredits($faker->numberBetween(1, 10));
            $cour->setSyllabus($faker->paragraph(4));
            $cour->setSemestre($faker->numberBetween(1, 10));
            $cour->setNbCm($faker->numberBetween(10, 40));
            $cour->setNbTd($faker->numberBetween(5, 30));
            $cour->setNbTp($faker->numberBetween(5, 30));
            $cour->setIsOptionnel($faker->boolean());
            $cour->setEnseignant($faker->randomElement($enseignants));

            $programmesSelection = $faker->randomElements($programmes, $faker->numberBetween(1, 3));
            foreach ($programmesSelection as $programme) {
                $cour->addProgramme($programme);
            }

            $autres = $faker->randomElements($enseignants, $faker->numberBetween(0, 3));
            foreach ($autres as $ens) {
                if ($ens === $cour->getEnseignant()) {
                    continue;
                }
                $cour->addEnseignant($ens);
            }

            $manager->persist($cour);
            $cours[] = $cour;
        }

        for ($i = 0; $i < 50; $i++) {
            $reference = new Reference();
            $auteurs = [];
            $nbAuteurs = $faker->numberBetween(1, 3);
            for ($a = 0; $a < $nbAuteurs; $a++) {
                $auteurs[] = $faker->name;
            }
            $reference->setAuteurs($auteurs);
            $reference->setTitre($faker->sentence(5));
            if ($faker->boolean(50)) {
                $reference->setEditeurOptionnel($faker->company);
            }

            $type = $faker->randomElement(['URL', 'DOI', 'ISBN']);
            $reference->setTypeId($type);
            if ($type === 'URL') {
                $reference->setIdentifiant($faker->url);
            } elseif ($type === 'DOI') {
                $reference->setIdentifiant('10.' . $faker->numberBetween(1000, 9999) . '/' . $faker->bothify('??????'));
            } else {
                $reference->setIdentifiant($faker->isbn13);
            }
            $reference->setDateDePublication($faker->numberBetween(1990, 2024));

            $coursRef = $faker->randomElement($cours);
            $coursRef->addListeReference($reference);

            $manager->persist($reference);
        }

        $manager->flush();
    }
}
