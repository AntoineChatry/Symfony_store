<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use App\Entity\User;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @Route("user/", name="user")
     */
    public function index( UserRepository $UserRepository, ProductRepository $ProductRepository): Response
    {
        return $this->render('user/user.html.twig', [
            'users' => $UserRepository->findAll(),
            'products' => $ProductRepository->findAll(),
        ]);
    }
    // Search function for the user
    /**
     * @Route("user/search/{name}", name="user_search")
     */
    public function search(User $user, UserRepository $UserRepository): Response
    {
        return $this->render('user/user.html.twig', [
            'name' => $user,
            'name' => $UserRepository->findAll(),
        ]);
    }
}