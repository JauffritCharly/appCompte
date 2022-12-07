<?php

namespace App\Form;

use App\Entity\Questionnaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionnaireFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('salaire', null, ['attr' => ['class' => 'salaire-net'], 'label' => 'Votre revenus mensuel :'])
            ->add('autreRevenus', null, ['label' => 'Le montant de vos autres revenus :'])
            ->add('depenses', null, ['label' => 'Quels est le montants de vos dépenses récurrentes ?'])
            ->add('methodeEconomie', ChoiceType::class, ['label' => 'Quelles type d\'économie souhaitez vous faire :', 'choices' => [
                'Économiser au maxium (75% des revenues sont sauvegardés)' => 75,
                'Économiser de façon optimisé (50% des revenues sont sauvegardés)' => 50,
                'Économiser de façon normal (33% des revenues sont sauvegardés)' => 33,
                'Économiser de façon classique (25% des revenues sont sauvegardés)' => 25,
                'Économiser de façon légère (10% des revenues sont sauvegardés)' => 10,
                'Je souhaite simplement utiliser ComptApp pour la prévision' => 0
            ]])
            ->add('send', SubmitType::class, ['attr' => ['class' => 'btnTerminer'], 'label' => 'TERMINER']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Questionnaire::class,
        ]);
    }
}
