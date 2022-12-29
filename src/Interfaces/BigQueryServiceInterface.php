<?php
namespace App\Interfaces;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Request;

interface BigQueryServiceInterface
{
    public function __construct(ContainerBagInterface $params);

    public function getPostList(Request $request): array;

    public function getPost(Request $request, int $id): array;

    public function getPostComents(Request $request, int $postId): array;
}
