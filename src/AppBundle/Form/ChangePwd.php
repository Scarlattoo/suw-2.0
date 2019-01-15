<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ChangePwd
 * @package AppBundle\Form
 */
class ChangePwd extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('password', PasswordType::class, array(
            'attr' => array('placeholder' => 'Twoje obecne hasło'),
            'label' => false,
        ));
        $builder
            ->add('plainPassword', RepeatedType::class,array(
                'type' => PasswordType::class,
                'invalid_message' => 'Hasła muszą być takie same',
                'first_options'  => array('attr' => array('placeholder' => 'Twoje nowe hasło', 'maxlength' => 255), 'label' => false),
                'second_options' => array('attr' => array('placeholder' => 'Powtórz nowe hasło'), 'label' => false),
            ))
            ->add('Zmien haslo', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-primary'),
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }
}
