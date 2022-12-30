<?php
namespace App\Interfaces;

use App\Models\Params;

interface PostRepositoryInterface
{
    public function getPosts(Params $params): array;

    public function getPost(Params $params, int $id): array;

    public function getPostComents(Params $params, int $postId): array;
}
