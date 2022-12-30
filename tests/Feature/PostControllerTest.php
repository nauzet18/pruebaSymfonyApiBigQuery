<?php

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use App\Interfaces\BigQueryServiceInterface;
use App\Tests\BigQueryServiceMockTrait;

class PostControllerTest extends WebTestCase
{
    use BigQueryServiceMockTrait;

    private $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();

        $bigQueryService = $this->configBigQueryServiceMock();
        $container = static::getContainer();
        $container->set(BigQueryServiceInterface::class, $bigQueryService);
    }

    public function testAll(): void
    {
        $crawler = $this->client->request('GET', '/posts');
        $this->assertResponseIsSuccessful();

        $posts = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertIsArray($posts);

        $this->assertArrayHasKey('id', $posts[0] );
        $this->assertArrayHasKey('title', $posts[0] );
        $this->assertArrayHasKey('body', $posts[0] );
    }

    public function testShow(): void
    {
        $crawler = $this->client->request('GET', '/posts/1');
        $this->assertResponseIsSuccessful();

        $posts = json_decode($this->client->getResponse()->getContent(), true);
        $post = $posts[0];

        $this->assertIsArray($post);
        $this->assertArrayHasKey('id', $post );
        $this->assertArrayHasKey('title', $post );
        $this->assertArrayHasKey('body', $post );
    }

    public function testComments(): void
    {
        $crawler = $this->client->request('GET', '/posts/1/comments');
        $this->assertResponseIsSuccessful();

        $posts = json_decode($this->client->getResponse()->getContent(), true);
        $post = $posts[0];

        $this->assertIsArray($post);
        $this->assertArrayHasKey('id', $post );
        $this->assertArrayHasKey('text', $post );
        $this->assertArrayHasKey('user_id', $post );
    }
}
