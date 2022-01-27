<?php

namespace App\Form\EventListener;

use App\Entity\Order;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ClearCartListener implements EventSubscriberInterface
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [FormEvents::POST_SUBMIT => 'postSubmit'];
    }
    /**
     * Removes items from the cart when clear button is clicked
     * 
     * @param FormEvent $event
     */
    public function postSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $cart = $form->getData();

        if(!$cart instanceof Order) {
            return;
        }
        // Clear button clicked ?
        if(!$form->get('clear')->isClicked()) {
            return;
        }
        // Clear cart
        $cart->removeItems();
    }
}