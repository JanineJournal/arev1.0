<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RadioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('operateurSim', null, array(
                'required' => false))
            ->add('numSeriesim', NumberType::class, array('label' => "N° Série Sim",
                'required' => false))
	        ->add('emplacementdisj', TextType::class, array('label' => "Emplacement Disjoncteur",
	                                                      'required' => false))
	        ->add('emplacementClavier', TextType::class, array('label' => "Emplacement Clavier",
	                                                      'required' => false))
	        ->add('emplacementHP', TextType::class, array('label' => "Emplacement HP",
	                                                      'required' => false))
            ->add('numTelsim', NumberType::class, array('label' => "N° Tel Sim",
                'required' => false));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'cascade_validation' => true,
            'data_class' => 'AppBundle\Entity\Radio'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_radio';
    }


}
