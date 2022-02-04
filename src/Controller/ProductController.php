<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\AddToCartType;
use App\Manager\CartManager;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CreateProductForm;
use App\Form\AddQuestionType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Question;


/**
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id}", name="product.detail", methods={"GET", "POST"})
     * @param String $id
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function detail(string $id, ProductRepository $productRepository, Product $product, Request $request, CartManager $cartManager, EntityManagerInterface $em ): Response
    {
        $question = new Question();
        $fo = $this->createForm(AddQuestionType::class, $question);
        $fo->handleRequest($request);
        if ($fo->isSubmitted() && $fo->isValid()) {
            $question = $fo->getData();
            $question->setCreator($this->getUser());
            $product->addQuestion($question);
            $em->persist($question);
            $em->flush();
        }

        $form = $this->createForm(AddToCartType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() &&  $form->isValid()){
            $item = $form->getData();
            $item->setProduct($product);
            $cart = $cartManager->getCurrentCart();
            $cart
                ->addItem($item)
                ->setUpdatedAt(new \DateTime());
            
            $cartManager->save($cart);
            return $this->redirectToRoute('product.detail',['id' => $product->getId()]);
            
        }

        return $this->render('product/detail.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'questionform' => $fo->createView(),
        ]);
    }
    /**
     * @Route("addProducts", name="addProducts", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function addProducts(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product();
        $form = $this->createForm(CreateProductForm::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $product->setCreator($this->getUser());
            $product->setDate(new \DateTime());

            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('product/addProducts.html.twig', [
            'addForm' => $form->createView(),
        ]);
    }
    /**
     * @Route("/product/delete/{id}", name="product.delete")
     */
    public function delete(Product $product, EntityManagerInterface $em): Response
    {
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('home');
    }
    // Edit button
    /**
     * @Route("/product/edit/{id}", name="product.edit")
     */
    public function edit(Product $product, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CreateProductForm::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $product->setCreator($this->getUser());
            $product->setDate(new \DateTime());

            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('product/edit.html.twig', [
            'editForm' => $form->createView(),
        ]);
    }
}
