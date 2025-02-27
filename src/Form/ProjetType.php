<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Projet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $employesProjet = $options['employesProjet']?? [];
        $allEmployes = $options['allEmployes']?? [];
        $builder
            ->add('nomProjet')
            ->add('employes', EntityType::class, [
                'class' => Employe::class,
                'choice_label' => fn(Employe $allEmployes) => $allEmployes->getPrenom() . ' ' . $allEmployes->getNom(),
                'choices' => $allEmployes,
                'multiple' => true,
                'expanded' => false,
                'data' => $employesProjet,
                'attr' => [
                    'class' => 'tom-select2',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
            'employesProjet' => null,
            'allEmployes' => null,
        ]);
    }
}
