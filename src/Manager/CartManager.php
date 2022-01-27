<?php

namespace App\Manager;
use App\Entity\Order;
use App\Factory\OrderFactory;
use App\Storage\CartSessionStorage;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CartManager
 * @package App\Manager
 */
class CartManager
{
    /**
     * @var CartSessionStorage
     */
    private $cartSessionStorage;
    /**
     * @var OrderFactory
     */
    private $cartFactory;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
     /**
     * CartManager constructor.
     * @param CartSessionStorage $cartSessionStorage
     * @param OrderFactory $orderFactory
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(CartSessionStorage $cartSessionStorage, OrderFactory $orderFactory, EntityManagerInterface $entityManager)
    {
        $this->cartSessionStorage = $cartSessionStorage;
        $this->cartFactory = $orderFactory;
        $this->entityManager = $entityManager;
    }
    /** get current cart
     * @return Order
     */
    public function getCurrentCart(): Order
    {
        $cart = $this->cartSessionStorage->getCart();
        if (!$cart) {
            $cart = $this->cartFactory->create();
        }
        return $cart;
    }
    /**
     * Persist the cart in db and session
     * @param Order $cart
     */
    public function save(Order $cart): void
    {
        // Db
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
        // session
        $this->cartSessionStorage->setCart($cart);
    }

}