<?php

namespace HuntkingdomBundle\Form;

use HuntkingdomBundle\Entity\Animals;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChasseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('region',ChoiceType::class,[
            'choices'=>['Bizerte'=>'Bizerte','Zaghouan'=>'Zaghouan','Nabeul'=>'Nabeul']
        ])->add('dateDebut', DateType::class, ['widget' => 'single_text'
        ])->add('dateFin', DateType::class, [
            'widget' => 'single_text',

            // prevents rendering it as type="date", to avoid HTML5 date pickers


            // adds a class that can be selected in JavaScript

        ])->add('animal',EntityType::class,
            ['class'=>Animals::class,
                'choice_label'=>'nom',
                'placeholder' => 'Choose an option'



            ]

        )->add('type',ChoiceType::class,[
            'choices'=>['herbivore'=>'herbivore','carnivore'=>'carnivore','Autres'=>'Autres']
        ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HuntkingdomBundle\Entity\Chasse'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'huntkingdombundle_chasse';
    }


}
