<?php

namespace App\Form\Type;

use App\Entity\User;
use App\Entity\WorkEntry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkEntryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userId', EntityType::class, [
                'class' => User::class
            ])
            ->add('startDate', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy HH:mm:ss',
                'html5' => false
            ])
            ->add('endDate', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy  HH:mm:ss',
                'html5' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WorkEntry::class,
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
