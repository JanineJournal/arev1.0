<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FicheType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('coderacco')
	        ->add('operateurtp', TextType::class, array(
		        'label' => "Opérateur TP",
		        'disabled' => true,
		        'required' => true))
	        ->add('mdpClient', TextType::class, array('label' => "MDP Client",
	                                                  'required' => false))
	        ->add('commentairetp', TextareaType::class, array('label' => "Commentaire TP",
	                                                          'required' => false))
	        ->add('commentaire', TextareaType::class, array('label' => "Commentaire général",
	                                                        'required' => false))
	        ->add('appsmartphone', AppsmartphoneType::class, array(
		        'label' => false
	        ))
	        ->add('localisationCentrale', TextType::class, array(
		        'required' => false))
	        ->add('numserieCentrale', TextType::class, array(
		        'label' => 'Numéro Série',
		        'required' => false))
	        ->add('Enregistrer', SubmitType::class, array(
		        'attr' => array('class' => 'btn btn-lg'), 'label' => 'Enregistrer la fiche'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'cascade_validation' => true,
            'data_class' => 'AppBundle\Entity\Fiche'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_fiche';
    }

}
