<?php

namespace AppBundle\Form;

use AppBundle\Entity\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
        $builder->add('lectureFile', FileType::class, array('label' => 'Wybierz plik PDF', 'attr' => array(),'required' => false, 'data_class' => null))
            ->add('title',TextType::class, array('label' => 'Tytuł','attr' => array('maxlength' => 255),'required' => false))
            ->add('description',TextareaType::class, array('label' => 'Opis','attr' => array('maxlength' => 255),'required' => false))
            ->add('type',TextType::class, array('label' => 'Typ','attr' => array('maxlength' => 255),'required' => false))
            ->add('filename',TextType::class, array('label' => 'Nazwa pliku','attr' => array('maxlength' => 255),'required' => false))
            ->add('course',EntityType::class, array('label' => 'Kurs','attr' => array(),'class' => 'AppBundle:Course','choices' => $courses));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => File::class,
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