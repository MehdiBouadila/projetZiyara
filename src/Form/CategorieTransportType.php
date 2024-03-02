<?php

namespace App\Form;

use App\Entity\CategorieTransport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class CategorieTransportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomCategorieTransport', TextType::class, [
                'label' => 'Nom de la catégorie de transport',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom de la catégorie de transport ne peut pas être vide',
                    ]),
                    new Regex([
                        'pattern' => '/^\p{L}+$/u',
                        'message' => 'Le nom de la catégorie de transport ne peut contenir que des lettres',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorieTransport::class,
        ]);
    }
}
