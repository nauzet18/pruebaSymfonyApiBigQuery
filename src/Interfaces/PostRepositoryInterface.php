<?php
namespace App\Interfaces;

use Symfony\Component\HttpFoundation\Request;

interface PostRepositoryInterface
{
    public function getPosts(Request $request): array;

    public function getPost(Request $request, int $id): array;

    public function getPostComents(Request $request, int $postId): array;
}
