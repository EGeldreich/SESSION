<?php

namespace App\Form;

use App\Entity\Lesson;
use App\Entity\Program;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProgramLessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('lesson', EntityType::class, [
            'class' => Lesson::class,
            'choices' => $options['nonScheduledLessons'],
            'choice_label' => 'name',
            'label' => 'Lesson',
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Duration (days)',
                'attr' => [
                    'min' => 1,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
            'nonScheduledLessons' => [],
            // Configure your form options here
        ]);
    }
}
