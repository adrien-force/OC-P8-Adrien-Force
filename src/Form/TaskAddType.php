<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Project;
use App\Entity\Status;
use App\Entity\Tag;
use App\Entity\Task;
use App\Entity\Timeslot;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',
                null,
                [
                    'label' => 'Titre',
                    'required' => true,
                ])
            ->add('description')
            ->add('deadline', null, [
                'widget' => 'single_text'
            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'name',
            ])
            ->add('employe', EntityType::class, [
                'class' => Employe::class,
                'choice_label' => 'fullname',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
