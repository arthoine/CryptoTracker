<?php

namespace App\Form;

use App\Entity\Transaction;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SellType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', EntityType::class, array(
                'class'    => 'App\Entity\CryptoWallet',
                'choice_label'  => 'name',
                'expanded' => false,
                'multiple' => false,
                'placeholder'=>'Sélectionner une crypto'
            ))
            ->add('quantity', NumberType::class, [
                'attr' => [
                    'placeholder'=>"Quantité"
                ],

            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
