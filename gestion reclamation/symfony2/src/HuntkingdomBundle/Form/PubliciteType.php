<?php

namespace HuntkingdomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PubliciteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')->add('file',FileType::class,['required'=>false] )->add('dateDebut', DateTimeType::class, ['widget' => 'single_text', 'attr' => ['class' => 'form-control']
        ])->add('dateFin', DateTimeType::class, [
            'widget' => 'single_text',

            // prevents rendering it as type="date", to avoid HTML5 date pickers


            // adds a class that can be selected in JavaScript
            'attr' => ['class' => 'form-control'],
        ])->add('nomProprietaire')->add('position',ChoiceType::class,['choices'=>[ 'Position 1'=>1,'Position 2'=>2,'Position 3'=>3]
        ])
            ->add('prix',IntegerType::class)
        ;
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HuntkingdomBundle\Entity\Publicite'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'huntkingdombundle_publicite';
    }


}
