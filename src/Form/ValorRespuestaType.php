<?php

namespace App\Form;

use App\Entity\ValorRespuesta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ValorRespuestaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('respuesta')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('pregunta')
            ->add('formulario')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ValorRespuesta::class,
        ]);
    }
}
