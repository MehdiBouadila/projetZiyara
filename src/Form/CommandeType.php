<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('statut', ChoiceType::class, [
                'multiple' => false, 
                'expanded' => false,
                'choices' => [
                    'En cours' => 'en cours',
                    'En attente' => 'en attente',
                    'Terminee' => 'terminee',
                ],
                'placeholder' => 'Choisir les types',
                'required' => false,
            ])
            ->add('total')
            ->add('type_paiement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
