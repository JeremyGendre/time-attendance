<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            ['name' => 'Informatique', 'shortname' => 'IT'],
            ['name' => 'Direction', 'shortname' => 'DIR'],
            ['name' => 'Administratif', 'shortname' => 'ADM'],
        ];

        foreach ($data as $serviceInfos){
            $service = new Service();
            $service
                ->setName($serviceInfos['name'])
                ->setShortname($serviceInfos['shortname']);
            $manager->persist($service);
        }

        $manager->flush();
    }
}
