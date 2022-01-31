<?php


namespace App\Form;

use App\Entity\Product;
use App\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class CreateProductForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Product name',
                'attr' => [
                    'placeholder' => 'Product name',
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Description',
                ],
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Price',
                'attr' => [
                    'placeholder' => 'Price',
                ],
            ])
            ->add('tag', EntityType::class, [
                'label' => 'Tag',
                'class' => Tag::class,
                'choice_label' => 'name',
                'attr' => [
                    'placeholder' => 'Tag',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}