<?php

namespace App\Form;

use App\Entity\Cadeau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CadeauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contenu' , null , ['label'=>'Type du sujet  : '])
            ->add('imageFile' , VichImageType::class , ['required'=>false ,'label'=>'Photo du sujet  : '])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cadeau::class,
        ]);
    }
}
