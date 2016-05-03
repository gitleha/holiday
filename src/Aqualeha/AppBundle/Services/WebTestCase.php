<?php

namespace Aqualeha\AppBundle\Services;

use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM;
use Nelmio\Alice\Fixtures\Parser\Methods\Yaml;
use Nelmio\Alice\Persister\Doctrine;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

/**
 * Classe de base pour tout les tests pour contenir les méthodes reutilisées
 *
 * @package Leha\CentralBundle\Tests
 */
class WebTestCase extends BaseWebTestCase
{
    /**
     * @var
     */
    protected $client;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    protected $linesNumber;

    /**
     * Setup function
     */
    public function setUp()
    {
        $this->client = self::createClient();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->linesNumber = 5;
    }

    /**
     * Permet de renvoyer un objet client avec le contexte de l'utilisateur $username
     *
     * @param string $username
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    public function getClient($username)
    {
        if (null === static::$kernel) {
            static::$kernel = static::createKernel();
        }

        $testUsers = array(
            'admin' => 'admin',
            'ceq' => 'ceq',
            'ceq2' => 'ceq2',
            'ceq3' => 'ceq3',
            'autreClient' => 'leha35',
            'leha'  => 'leha',
            'charlie'  => 'charlie',
            'importLme' => 'importLme',
            'labo_007' => 'leha35',
            'vdourdain' => 'leha35',
            'adminUser' => 'leha',
            'valideurAS'    => 'leha',
            'carrefour' => 'carrefour',
            'fournisseur1' => 'fournisseur1'
        );

        return static::createClient(array(), array(
            'PHP_AUTH_USER' => $username,
            'PHP_AUTH_PW' => $testUsers[$username]
        ));
    }

    /**
     * Drop la base et la recrée
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    protected static function generateSchema()
    {
        if (null === static::$kernel) {
            static::$kernel = static::createKernel();
        }

        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $metadata = $em->getMetadataFactory()->getAllMetadata();

        if (!empty($metadata)) {
            $tool = new SchemaTool($em);
            $tool->dropDatabase();
            $tool->createSchema($metadata);
        } else {
            throw new SchemaException('First Test For Attributs');
        }
    }

    /**
     * Charger les fixtures de CentralBundle selon le parametre.
     *
     * @param EntityManager     $em
     * @param string            $fixtureFile
     */
    protected function loadFixtures($em, $fixtureFile)
    {
        $loader = new Yaml();
        $bundles = static::$kernel->getBundles();

        $objects = $loader->load($bundles['LehaCentralBundle']->getPath() . '/Resources/fixtures/' . $fixtureFile);

        $toPersist = array();
        foreach ($objects as $object) {
            $toPersist[get_class($object)][] = $object;
        }

        foreach ($toPersist as $objects) {
            $persister = new Doctrine($em);
            $persister->persist($objects);
        }
    }

    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        if ($this->em != null) {
            $this->em->getConnection()->close();
        }

        parent::tearDown();
    }
}
?>