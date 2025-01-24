<?php

namespace App\Form;

use App\Entity\Lesson;
use App\Entity\Program;
use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('programs', CollectionType::class, [
            'entry_type' => ProgramLessonType::class,
            'entry_options' => [
                'nonScheduledLessons' => $options['nonScheduledLessons'],
                'label' => false,
            ],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'prototype' => true,
            
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
            ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            // 'csrf_protection' => false,
        ]);
        
        $resolver->setRequired(['nonScheduledLessons']);
    }
}
        
        // $builder
        //     ->add('duration', NumberType::class, [
        //         'attr' => [
        //             'class' => 'form-input'
        //         ]
        //     ])
        //     // ->add('session', EntityType::class, [
        //     //     'class' => Session::class,
        //     //     'choice_label' => 'id',
        //     // ])
        //     // ->add('lesson', EntityType::class, [
        //     //     'class' => Lesson::class,
        //     //     'choice_label' => 'id',
        //     // ])
        //     ->add('lesson', CollectionType::class, [
        //         'entry_type' => EntityType::class,
        //         'entry_options' => [
        //             'class' => Lesson::class,
        //             'choice_label' => 'name',
        //         ],
        //         'allow_add' => true,
        //         'allow_delete' => false,
        //         'by_reference' => false,
        //     ])
        //     ->add('submit', SubmitType::class, [
        //         'attr' => [
        //             'class' => 'submit-btn'
        //         ]
        //     ])
        // ;