<?php

namespace Aqualeha\TwigBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DefaultControllerTest
 *
 * @package Aqualeha\TwigBundle\Tests\Controller
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * Test Hello
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hello/Fabien');

        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }
}
