<?php

namespace App\Tests\Feature\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;

use App\Tests\BigQueryServiceMockTrait;
use App\Interfaces\BigQueryServiceInterface;
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
        $request = new Request();

        $data = $this->repository->getPosts($request);

        $this->assertIsArray($data);
    }

    public function testGetPost(): void
    {
        $request = new Request();
        $data = $this->repository->getPost($request, 1);

        $this->assertIsArray($data);
    }

    public function testGetPostComents(): void
    {
        $request = new Request();
        $data = $this->repository->getPostComents($request, 1);

        $this->assertIsArray($data);
    }
}
