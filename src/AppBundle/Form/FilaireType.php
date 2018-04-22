<?php

namespace AppBundle\Form;

use AppBundle\Entity\CentraleFilaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilaireType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresseip',null, array('label' => 'Adresse IP'))
            ->add('gsm')
            ->add('ipfixe', null, array('label' => 'IP fixe'))
            ->add('portspc', null, array('label' => 'Port SPC'))
            ->add('portsortant', null, array('label' => 'Port Sortant'))
            ->add('portweb', null, array('label' => 'Port Web'))
            ->add('mdpweb', null, array('label' => 'Mot de Passe Web'))
            ->add('fai')
            ->add('clecryptage', null, array('label' => 'Clé de cryptage'))
            ->add('gestionhoraire', null, array('label' => 'Gestion Horaire'))
            ->add('gmesappel', null, array('label' => 'Gmes auto'))
            ->add('mesauto', null, array('label' => 'MES auto'))
            ->add('operateurSim', null, array('label' => 'Opérateur SIM'))
            ->add('numCarteSim', null, array('label' => 'N° Carte SIM'))
            ->add('numVoix', null, array('label' => 'Numéro Voix '))
            ->add('numData', null, array('label' => 'Numéro Data'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Filaire',
                        'cascade_validation' => true,

        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_filaire';
    }


}
