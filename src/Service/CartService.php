<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private RequestStack $requestStack;
    private EntityManagerInterface $em;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        // injection de dépendances
        $this->requestStack = $requestStack;
        $this->em = $em;
    }

    public function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }

    public function addCart(int $id): void
    {
        // récupération du tableau de produits ajoutés au panier depuis la session 
        // utilisateur
        $cart = $this->getSession()->get('cart', []);

        // vérifier si le produit existe déjà dans le panier
        if(!empty($cart[$id]))
        {
            // si le produit existe, on incrémente la quantité
            $cart[$id]++; 
        }else
        {
            //sinon on ajoute le produit au panier
            $cart[$id] = 1;
        }
        // mise à jour du panier dans la session utilisateur
        $this->getSession()->set('cart', $cart);
    }

    public function getTotal()
    {
        // récupération du tableau de produits ajoutés au panier depuis la session utilisateur
        $cart = $this->getSession()->get('cart');
        $cartData = [];
        if($cart)
        {
            foreach($cart as $id => $q)
            {
                // récupération du produit à partir de son id en bdd
                $fetchProduct = $this->em->getRepository(Product::class)->findOneBy(['id' => $id]);
                if($fetchProduct)
                {
                    $cartData[] = [
                        'product' => $fetchProduct,
                        'quantity' => $q
                    ];
                }
            }
        }
        // return le tableau de produits avec leurs informations et quantités
        return $cartData;
    }

    public function decrease(int $id)
    {
        // récupération du tableau de produit ajoutés au panier depuis la session utilisateur 
        $cart = $this->getSession()->get('cart', []);
        // vérification si la quantité du produit est superieur à 1 pour pouvoir décrémenter
        if($cart[$id] > 1)
        {
            $cart[$id]--;
        }
        else {
            // si la quantité de produit est égale à 1, on supprime le produit du panier
            unset($cart[$id]);
        }
        return $this->getSession()->set('cart', $cart);
    }

    public function deleteCart(int $id)
    {
        // récupération du tableau de produits ajouté au panier depuis la session utilisateur
        $cart = $this->getSession()->get('cart', []);
        // Suppression du produit qui est dans le panier
        unset($cart[$id]);
        return $this->getSession()->set('cart', $cart);
    }

    public function deleteAllCart()
    {
        return $this->getSession()->remove('cart');
    }
}

?>