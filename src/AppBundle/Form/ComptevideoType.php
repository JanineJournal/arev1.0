<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComptevideoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('identifiant', null, array('label' => false))
            ->add('localisation', null, array('label' => false))
            ->add('codecompte', null, array('label' => false))
            ->add('emailCompteVideo', null, array('label' => false))
            ->add('questioncomptevideo', null, array('label' => false))
            ->add('reponsecomptevideo', null, array('label' => false));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'cascade_validation' => true,
            'data_class' => 'AppBundle\Entity\Comptevideo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_comptevideo';
    }


}
