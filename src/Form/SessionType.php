<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-input'
                ]
            ])
            ->add('place', NumberType::class, [
                'attr' => [
                    'class' => 'form-input'
                ]
            ])
            ->add('dateStart', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-input'
                ]
            ])
            ->add('dateEnd', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-input'
                ]
            ])
            // ->add('students', EntityType::class, [
            //     'class' => Student::class,
            //     'choice_label' => 'name',
            //     'multiple' => true,
            // ])
            ->add('teacher', EntityType::class, [
                'class' => Teacher::class,
                'choice_label' => 'name',
            ])
            ->add('formation', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => 'name',
            ])
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
            'data_class' => Session::class,
        ]);
    }
}
