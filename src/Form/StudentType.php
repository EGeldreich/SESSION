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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('firstname', TextType::class)
            ->add('dateBirth', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('city', TextType::class)
            ->add('email', EmailType::class)
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Female' => 'F',
                    'Male' => 'M',
                    'Non-Binary' => 'NB',
                ]
            ])
            ->add('phone', TelType::class)
            // ->add('sessions', EntityType::class, [
            //     'class' => Session::class,
            //     'choice_label' => 'name',
            //     'multiple' => true,
            // ])
            ->add('submit', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
