<?php
namespace App\Interfaces;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use App\Models\Params;

interface BigQueryServiceInterface
{
    public function __construct(ContainerBagInterface $params);

    public function getPostList(Params $params): array;

    public function getPost(Params $params, int $id): array;

    public function getPostComents(Params $params, int $postId): array;
}
