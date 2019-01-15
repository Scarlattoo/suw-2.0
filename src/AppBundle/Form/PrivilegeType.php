<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrivilegeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder->add('user', ChoiceType::class,
                array(
                    'label' => 'Wybierz użytkownika:',
                    'choices' => $options['choices'],
                    'choices_as_values' => false,
                    'attr' => array(
                        'autofocus' => 'autofocus')
                ))
                ->add('submit', SubmitType::class, array('label' => 'Nadaj', 'attr' => array('class' => 'btn btn-primary ml-0 mt-0'))
            );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Privilege',
            'choices' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_privilege';
    }


}
