<?php
namespace App\Repositories;

use Symfony\Component\HttpFoundation\Request;

use App\Interfaces\PostRepositoryInterface;
use App\Interfaces\BigQueryServiceInterface;

class PostRepository implements PostRepositoryInterface
{
    private BigQueryServiceInterface $bigQueryClient;

    public function __construct(BigQueryServiceInterface $bigQueryClient)
    {
        $this->bigQueryClient = $bigQueryClient;
    }

    public function getPosts(Request $request): array
    {
        try {
            $posts = $this->bigQueryClient->getPostList($request);
            //TODO: serializar

        } catch (\Exception $e) {
            throw $e;
        }

        return $posts;
    }

    public function getPost(Request $request, int $id): array
    {
        try {

            $post = $this->bigQueryClient->getPost($request, $id);
            //TODO: serializar

        } catch (\Exception $e) {
            throw $e;
        }

        return $post;
    }

    public function getPostComents(Request $request, int $postId): array
    {
        try {

            $coments = $this->bigQueryClient->getPostComents($request, $postId);
            //TODO: serializar

        } catch (\Exception $e) {
            throw $e;
        }

        return $coments;
    }
}
