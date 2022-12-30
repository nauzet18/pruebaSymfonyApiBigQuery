<?php
namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Interfaces\BigQueryServiceInterface;
use App\Models\Params;

class PostRepository implements PostRepositoryInterface
{
    private BigQueryServiceInterface $bigQueryClient;

    public function __construct(BigQueryServiceInterface $bigQueryClient)
    {
        $this->bigQueryClient = $bigQueryClient;
    }

    public function getPosts(Params $params): array
    {
        try {
            $posts = $this->bigQueryClient->getPostList($params);
            //TODO: serializar

        } catch (\Exception $e) {
            throw $e;
        }

        return $posts;
    }

    public function getPost(Params $params, int $id): array
    {
        try {

            $post = $this->bigQueryClient->getPost($params, $id);
            //TODO: serializar

        } catch (\Exception $e) {
            throw $e;
        }

        return $post;
    }

    public function getPostComents(Params $params, int $postId): array
    {
        try {

            $coments = $this->bigQueryClient->getPostComents($params, $postId);
            //TODO: serializar

        } catch (\Exception $e) {
            throw $e;
        }

        return $coments;
    }
}
