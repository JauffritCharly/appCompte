<?php

namespace App\Form;

use App\Entity\ArgentEconomisees;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArgentEcoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('economie', null, ['label' => 'Combien avez vous mis de cotés ce mois-ci :'])
            ->add('send', SubmitType::class, ['attr' => ['class' => 'btn-ajouter'], 'label' => 'AJOUTER']);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArgentEconomisees::class,
        ]);
    }
}
