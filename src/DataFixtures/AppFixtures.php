<?php

namespace App\DataFixtures;

use App\Factory\EmployeFactory;
use App\Factory\ProjectFactory;
use App\Factory\StatusFactory;
use App\Factory\TagFactory;
use App\Factory\TaskFactory;
use App\Factory\TimeslotFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        EmployeFactory::createMany(10);
        StatusFactory::createMany(3);
        TagFactory::createMany(3);
        TaskFactory::createMany(10);
        TimeslotFactory::createMany(10);
        ProjectFactory::createMany(4);

    }
}
