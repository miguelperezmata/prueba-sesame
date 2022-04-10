<?php

namespace App\Form\Type;

use App\Entity\User;
use App\Form\Model\BookDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('email', EmailType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false
        ]);
    }

    /*
    * De esta manera evitamos el envio del form que utiliza symfony en las llamadas
    */
    public function getBlockPrefix()
    {
        return '';
    }

    public function getName()
    {
        return '';
    }
}
