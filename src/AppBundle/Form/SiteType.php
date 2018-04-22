<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('codeSite', null, array('label'=>'Code Site', 'disabled'=>true))
            ->add('nomSite', null, array('disabled'=>true))
            ->add('adresseSite01',null, array('label' => 'Adresse', 'disabled'=>true))
            ->add('codePostalSite',null, array('label' => 'Code Postal', 'disabled'=>true))
            ->add('villeSite', null, array('label' => 'Ville', 'disabled'=>true))
            ->add('numtel1',null, array('label' => 'N° tél. 1'))
            ->add('numtel2',null, array('label' => 'N° tél. 2'))
            ->add('numtel3', null, array('label' => 'N° tél. 3'))
            ->add('numtel4', null, array('label' => 'N° tél. 4'))
        ->add('client', ClientType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Site'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_site';
    }


}
