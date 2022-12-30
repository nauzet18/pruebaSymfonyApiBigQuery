<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Params;

#[Route(path: "/posts", name: "posts_")]
class PostController extends AbstractController
{
    /**
     * Get all posts (questions and answers) in the system.
    */
    #[Route(path: "", name: "all", methods: ["GET"])]
    function all(PostRepositoryInterface $repository, Request $request): Response
    {
        $params= new Params($request->query->all());
        $data = $repository->getPosts($params);

        return $this->json($data, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * Get all posts identified by a set of ids. Useful for when the type of post (question or answer) is not known.
    */
    #[Route(path: "/{id}", name: "show", methods: ["GET"])]
    function show(PostRepositoryInterface $repository, Request $request, int $id): Response
    {
        $params= new Params($request->query->all());
        $data = $repository->getPost($params, $id);

        return $this->json($data, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * Get comments on the posts (question or answer) identified by a set of ids.
    */
    #[Route(path: "/{id}/comments", name: "post_comments", methods: ["GET"])]
    function comments(PostRepositoryInterface $repository, Request $request, int $id): Response
    {
        $params= new Params($request->query->all());
        $data = $repository->getPostComents($params, $id);

        return $this->json($data, 200, ["Content-Type" => "application/json"]);
    }
}
