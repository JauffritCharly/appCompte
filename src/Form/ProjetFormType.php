<?php

namespace App\Form;

use App\Entity\Projets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomProjet', null, ['attr' => [
                'placeholder' => 'Nom de votre projet'],
                'label' => 'Quel type d\'acquisition souhaitez vous faire :'])
            ->add('montantProjet', null, ['label' => 'Quels est le prix de votre futur acquisition ?'])
            ->add('send', SubmitType::class, ['attr' => ['class' => 'btnAjouterProjet'], 'label' => 'AJOUTER']);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projets::class,
        ]);
    }
}
