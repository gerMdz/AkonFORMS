<?php

namespace App\Form;

use App\Entity\Pregunta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreguntaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('texto')
            ->add('orden')
            ->add('isActivo')
            ->add('parametros')
            ->add('isObligatoria')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('cuestionario')
            ->add('tipoPregunta')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pregunta::class,
        ]);
    }
}
