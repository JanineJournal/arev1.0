<?php

namespace AppBundle\Form;

use AppBundle\Repository\ParametreRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomclient', null, array('label' => 'Nom / Société', 'disabled'=>true))
            ->add('codeclient', null, array('label' => 'Code Client', 'disabled'=>true))
            ->add('type', EntityType::class, array('placeholder' => false,
            'class' => 'AppBundle:Parametre',
            'query_builder' => function(ParametreRepository $pr){
                return $pr->createQueryBuilder('tc')
                    ->where('tc.categorie = :type')
                    ->setParameter('type', 'Type Client')
                    ->orderBy('tc.id');
            },
            ))
            ->add('adresse01', null, array('label' => 'Adresse', 'disabled'=>true))
            ->add('codepostal', null, array('label' => 'Code Postal', 'disabled'=>true))
            ->add('villelocalite', null, array('label' => 'Ville/ Localité', 'disabled'=>true))
            ->add('numtel1', null, array('label' => 'N° tél. fixe', 'disabled'=>true))
            ->add('numtel2', null, array('label' => 'N° tél. mobile', 'disabled'=>true))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'cascade_validation' => true,
            'data_class' => 'AppBundle\Entity\Client'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_client';
    }
}
