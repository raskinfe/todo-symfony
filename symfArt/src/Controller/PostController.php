<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController {
	/**
	 * @Route("/posts", name="posts", methods="{POST}") 
	 */
	public function store(string $slug="") {
		var_dump($slug);
		return new Response('<h1>Hello from posts</h1>');
	}
}