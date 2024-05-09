<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'required' => true,
                'label' => 'Email'
            ])
            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'Utilisateur' => "",
                    'Administrateur' => "ROLE_ADMIN",                    
                ],
                'mapped' => false,
                'required' => false
            ])
            ->add('password', PasswordType::class,[
                'required' => true,
                'label' => 'Email'
            ])
            ->add('lastname', TextType::class,[
                'required' => true,
                'label' => 'Nom'
            ])
            ->add('firstname', TextType::class,[
                'required' => true,
                'label' => 'Prenom'
            ])
            ->add('phone', NumberType::class,[
                'required' => true,
                'label' => 'Téléphone'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
