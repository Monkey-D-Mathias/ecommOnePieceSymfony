<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType as SymfonyFileType;
use Symfony\Component\Validator\Constraints\File as ConstraintsFile;


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
            ->add('file', SymfonyFileType::class, [
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new ConstraintsFile([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                             'image/jpeg',
                             'image/png',
                             'image/jpg',
                         ]
                    ])
                ],
             ])
             ->add('public', CheckboxType::class, [
                "value"=> 1 ,
                'mapped' => false,
                'required' => false, // Si vous ne voulez pas que ce champ soit obligatoire
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
