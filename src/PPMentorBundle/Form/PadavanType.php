<?php

namespace PPMentorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PadavanType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'attr' => [
                    'placeholder' =>  "Name",
                ],
            ])
            ->add('email', null, [
                'attr' => [
                    'placeholder' =>  "Email",
                ],
            ])
            ->add('skills', null, [
                'attr' => [
                    'placeholder' =>  "Skills",
                ],
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PPMentorBundle\Entity\Padavan'
        ));
    }
}
