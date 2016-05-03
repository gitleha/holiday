<?php

namespace Aqualeha\AppBundle\Tests\Controller;

use Aqualeha\AppBundle\Controller\DefaultController;
use Aqualeha\AppBundle\Tests\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hello/Fabien');

        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }
}
