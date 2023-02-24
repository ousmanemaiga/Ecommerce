<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'get_cart')]
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
          'cart' => $cartService->getTotal(),
        ]);
    }

    #[Route('/add/cart/{id}', name: 'post_cart')]
    public function add( $id ,CartService $cartService): Response
    {
        $cartService->addCart($id);
        return $this->redirectToRoute('get_cart');       
    }

    #[Route('/delete/cart/{id}', name: 'delete_cart')]
    public function deleteCartById($id, CartService $cartService): Response
    {
        $cartService->deleteCart($id);
        return $this->redirectToRoute('get_cart');       
    }


    #[Route('/delete/all/cart', name: 'delete_all_cart')]
    public function delete( CartService $cartService): Response
    {
        $cartService->deleteAllCart();
        return $this->redirectToRoute('app_home');       
    }

    #[Route('/decrease/cart/{id}', name: 'decrease_cart')]
    public function decrease($id, CartService $cartService): Response
    {
        $cartService->decrease($id);
        return $this->redirectToRoute('get_cart');       
    }

}