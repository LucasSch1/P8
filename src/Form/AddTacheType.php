<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Projet;
use App\Entity\Statut;
use App\Entity\Tache;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddTacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('deadline', null, [
                'widget' => 'single_text',
            ])
//            ->add('projet', EntityType::class, [
//                'class' => Projet::class,
//                'choice_label' => 'id',
//            ])
            ->add('statut', EntityType::class, [
                'class' => Statut::class,
                'choice_label' => 'libelle',
                'choice_value' => 'id',
            ])
            ->add('employe', EntityType::class, [
                'class' => Employe::class,
                'choice_label' => 'prenom','nom',
                'choice_value' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
