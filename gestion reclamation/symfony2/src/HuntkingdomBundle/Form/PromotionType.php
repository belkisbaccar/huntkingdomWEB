<?php

namespace HuntkingdomBundle\Form;

use Doctrine\DBAL\Types\FloatType;
use Doctrine\ORM\EntityManager;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateDebut',DateType::class,['widget' => 'single_text', 'attr' => ['class' => 'form-control']])->add('dateFin',DateType::class,['widget' => 'single_text', 'attr' => ['class' => 'form-control']]);
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HuntkingdomBundle\Entity\Promotion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'huntkingdombundle_promotion';
    }


}
