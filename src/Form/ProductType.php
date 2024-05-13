<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'required' => true,
                'label' => 'Nom du produit*'
            ])
            ->add('description', TextType::class,[
                'required' => true,
                'label' => 'Description du produit'
            ])
            ->add('price_ht', NumberType::class,[
                'required' => true,
                'label' => 'Prix HT*'
            ])
            ->add('stock', NumberType::class,[
                'required' => true,
                'label' => 'Stock*'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
