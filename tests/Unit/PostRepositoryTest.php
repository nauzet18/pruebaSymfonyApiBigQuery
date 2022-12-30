<?php

namespace App\Tests\Feature\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use App\Tests\BigQueryServiceMockTrait;
use App\Interfaces\BigQueryServiceInterface;
use App\Models\Params;
use App\Repositories\PostRepository;

class PostRepositoryTest extends KernelTestCase
{
    use BigQueryServiceMockTrait;

    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $bigQueryService = $this->configBigQueryServiceMock();
        $container = static::getContainer();
        $container->set(BigQueryServiceInterface::class, $bigQueryService);
        $this->repository = $container->get(PostRepository::class);
    }

    public function testGetPosts(): void
    {
        $params= new Params();
        $data = $this->repository->getPosts($params);

        $this->assertIsArray($data);
    }

    public function testGetPost(): void
    {
        $params= new Params();
        $data = $this->repository->getPost($params, 1);

        $this->assertIsArray($data);
    }

    public function testGetPostComents(): void
    {
        $params= new Params();
        $data = $this->repository->getPostComents($params, 1);

        $this->assertIsArray($data);
    }
}
