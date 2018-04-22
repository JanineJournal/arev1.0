<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SecteurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('sp1',ChoiceType::class, array(
        'choices' => array(
            'Armé' => 'Armé',
            'Désarmé' => 'Désarmé',
            'Périmétrique' => 'Périmétrique',
            'Extérieur' => 'Extérieur') ))
            ->add('sp2',ChoiceType::class, array(
                'choices' => array(
                    'Armé' => 'Armé',
                    'Désarmé' => 'Désarmé',
                    'Périmétrique' => 'Périmétrique',
                    'Extérieur' => 'Extérieur') ))
            ->add('entree',null, array('label' => 'Entrée') )
            ->add('sortie')
            ->add('tempo')
            ->add('peripherique', CollectionType::class, array(
                'entry_type' => PeripheriqueType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Secteur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_zone';
    }
}
