<?php

namespace AppBundle\Form;

use AppBundle\Repository\ParametreRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HabiliteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('civilite',ChoiceType::class, array('placeholder' => false,
            'choices' => array(
                'M.' => 'M.',
                'Mme' => 'Mme',
                'Autre' => 'Autre',),
            'label' => 'Civilité') )
            ->add('nomhabili',null, array('label' => 'Nom') )
            ->add('prenomhabili',null, array('label' => 'Prénom') )
            ->add('typehabili', EntityType::class, array('placeholder' => false,
                'class' => 'AppBundle:Parametre',
                'query_builder' => function(ParametreRepository $pr){
                    return $pr->createQueryBuilder('th')
                        ->where('th.categorie = :type')
                        ->setParameter('type', 'Type Habilité')
                        ->orderBy('th.id');
                },
                'label' => 'Type') )
            ->add('numtel',null, array('label' => 'N° tél.1'))
            ->add('numtel2',null, array('label' => 'N° tél.2') )
            ->add('numtel3',null, array('label' => 'N° tél.3') )
            ->add('numtel4',null, array('label' => 'N° tél.4') )
            ->add('mdphabili',null, array('label' => 'MDP') );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Habilite'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_habilite';
    }


}
