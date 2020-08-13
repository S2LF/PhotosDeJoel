<?php

namespace App\Form;

use App\Entity\Expo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ExpoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre*:'
            ])
            ->add('date_Event', DateTimeType::class,[
                'label' => "Date de l'évènement"
            ])
            ->add('lieu', TextType::class, [
                'label' => 'Lieu:'
            ])
            ->add('contenu', TextareaType::class, [
                'label' => 'Description:' 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Expo::class,
        ]);
    }
}
