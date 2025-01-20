<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-input'
                ]
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-input'
                ]
            ])
            ->add('dateBirth', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-input'
                ]
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-input'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-input'
                ]
            ])
            ->add('gender', TextType::class, [
                'attr' => [
                    'class' => 'form-input'
                ]
            ])
            ->add('phone', TelType::class, [
                'attr' => [
                    'class' => 'form-input'
                ]
            ])
            // ->add('sessions', EntityType::class, [
            //     'class' => Session::class,
            //     'choice_label' => 'name',
            //     'multiple' => true,
            // ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'submit-btn'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
