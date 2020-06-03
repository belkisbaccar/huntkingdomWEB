<?php

namespace EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class evenementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titreEvent')->add('descriptionEvent')->add('file',FileType::class,['required'=>false] )->add('dateDebutEvent', DateType::class, ['widget' => 'single_text', 'attr' => ['class' => 'form-control']
        ])->add('dateFinEvent', DateType::class, [
            'widget' => 'single_text',

            // prevents rendering it as type="date", to avoid HTML5 date pickers


            // adds a class that can be selected in JavaScript
            'attr' => ['class' => 'form-control'],
        ])->add('nbPlaceEvent',IntegerType::class)
        ;
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EventBundle\Entity\Evenement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'Eventbundle_evenement';
    }


}
