<?php

namespace App\Form;

use App\Entity\Sondage;
use App\Entity\Question;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SondageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('titre',TextType::class,[
                'label'=>'Entrez le titre du sondage',
                'attr'=>
                    ['placeholder'=>'entrer le titre du sondage',
                        'style'=>'border:0;
  border-bottom:1px solid #555;  
  background:transparent;
  width:50%;
  padding:8px 0 5px 0;
  font-size:16px;
  color:black;'
                    ]
            ])
            ->add('nbParticipant',TextType::class,[

                'label'=>'Entrez le nombre de participant',
                'attr'=>
                    ['placeholder'=>'entrer le nombre des participants maximal'
                        ,
                        'style'=>'border:0;
  border-bottom:1px solid #555;  
  background:transparent;
  width:50%;
  padding:8px 0 5px 0;
  font-size:16px;
  color:black;'
                    ]

            ])
            //->add('nbQuestion')
            // ->add('nbReponse')
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sondage::class,
        ]);
    }
}
