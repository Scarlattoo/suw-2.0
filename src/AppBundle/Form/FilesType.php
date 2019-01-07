<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


class FilesType extends AbstractType
{
    protected $tokenStorage;

    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $courses=$user->getCourses()->getValues();
        $builder->add('lectureFile', FileType::class, array('label' => 'Wybierz plik PDF', 'attr' => array('class' => 'form-control-file'),'required' => false, 'data_class' => null))
            ->add('title',TextType::class, array('attr' => array('class' => 'form-control'),'required' => false))
            ->add('description',TextType::class, array('attr' => array('class' => 'form-control'),'required' => false))
            ->add('type',TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('filename',TextType::class, array('attr' => array('class' => 'form-control'),'required' => false))
            ->add('course',EntityType::class, array('attr' => array('class' => 'form-control'),'class' => 'AppBundle:Course','choices' => $courses));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\File',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_file';
    }


}