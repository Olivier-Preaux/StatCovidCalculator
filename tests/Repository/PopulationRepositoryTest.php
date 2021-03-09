<?php

namespace App\Tests\Repository;

use App\Entity\Population;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PopulationRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testSearchByFirstName()
    {
        $population = $this->entityManager
            ->getRepository(Population::class)
            ->findOneBy(['lastName' => 'Dupont'])
        ;

        $this->assertSame("Pierre", $population->getFirstName());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }


}