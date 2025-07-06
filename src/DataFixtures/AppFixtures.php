<?php

namespace App\DataFixtures;

use App\DataFixtures\Providers\EncodePasswordProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private EncodePasswordProvider $encodePasswordProvider;

    public function __construct(EncodePasswordProvider $encodePasswordProvider)
    {
        $this->encodePasswordProvider = $encodePasswordProvider;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $faker->addProvider($this->encodePasswordProvider);

        $loader = new NativeLoader($faker);

        $files = [
            __DIR__ . '/fixtures/user.yaml',
            __DIR__ . '/fixtures/offense.yaml',
            __DIR__ . '/fixtures/reward.yaml',
            __DIR__ . '/fixtures/redemptionmission.yaml',
            __DIR__ . '/fixtures/karma_action_fixtures.yaml',
            __DIR__ . '/fixtures/karma_score.yaml',
            __DIR__ . '/fixtures/redemptionvote.yaml',
        ];

        $objectSet = $loader->loadFiles($files);

    foreach ($objectSet->getObjects() as $object) {
        $manager->persist($object);
    }

    $manager->flush();
       
    }
}
