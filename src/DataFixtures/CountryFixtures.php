<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

// Countries offered on the registration form (phone prefix + local number length).
class CountryFixtures extends Fixture
{
    private const COUNTRIES = [
        ['Tunisia', '+216', 8],
        ['Algeria', '+213', 9],
        ['Morocco', '+212', 9],
        ['Libya', '+218', 9],
        ['Egypt', '+20', 10],
        ['France', '+33', 9],
        ['Italy', '+39', 10],
        ['Germany', '+49', 11],
        ['Spain', '+34', 9],
        ['United Kingdom', '+44', 10],
        ['Canada', '+1', 10],
        ['United States', '+1', 10],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::COUNTRIES as [$name, $prefix, $length]) {
            $country = (new Country())
                ->setName($name)
                ->setPhonePrefix($prefix)
                ->setPhoneNumberLength($length);
            $manager->persist($country);
        }

        $manager->flush();
    }
}
