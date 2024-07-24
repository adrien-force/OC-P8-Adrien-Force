<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Project;
use App\Entity\Status;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('startAt', null, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('deadline', null, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('archived',
                CheckboxType::class,
                [
                    'label' => 'Archive',
                    'required' => false,
                ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'name',
                'required' => false,
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'tag',
                'multiple' => true,
                'required' => false,
                'by_reference' => false,
            ])
            ->add('employes', EntityType::class, [
                'class' => Employe::class,
                'choice_label' => 'fullname',
                'multiple' => true,
                'required' => false,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
