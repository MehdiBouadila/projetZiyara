<?php

namespace App\Form;

use App\Entity\Transport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\CategorieTransport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class TransportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('imageTransport', FileType::class, [ 
            'label' => 'Image', 
            'mapped' => false, 
            'required' => false,
            // 'constraints' => [      // Commenting out this section
            //     new File([
            //         'maxSize' => '10k',
            //         'maxSizeMessage' => 'La taille de l\'image ne peut pas dépasser 10 Ko',
            //     ])
            // ]
        ])
        
            ->add('typeTransport', EntityType::class, [
                'class' => CategorieTransport::class,
                'choice_label' => 'nomCategorieTransport', 
            ])
            ->add('dateTransport')
            ->add('prixTransport')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transport::class,
        ]);
    }
}

