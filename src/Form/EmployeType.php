<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname',
                null,
                [
                    'label' => 'Nom',
                    'required' => true,
                ])
            ->add('firstname',
                null,
                [
                    'label' => 'Prénom',
                    'required' => true,
                ])
            ->add('email',
                null,
                [
                    'label' => 'Email',
                    'required' => true,
                ])
            ->add('contract',
                null,
                [
                    'label' => 'Contrat',
                    'required' => true,
                ])
            ->add('arrivalAt', null, [
                'widget' => 'single_text',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}
