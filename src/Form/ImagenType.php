<?php

namespace App\Form;

use App\Entity\Imagen;
use App\Entity\Categoria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ImagenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', FileType::class, [
                'label' => 'Nombre imagen (JPG o PNG)',
                'label_attr' => ['class' => 'etiqueta'],
                'data_class' => null,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Por favor, seleccione un archivo jpg o png',
                    ])
                ],
            ])
            ->add('descripcion', TextType::class, [
                'label' => 'Descripción:',
                'required' => false,
                'label_attr' => ['class' => 'etiqueta']
            ])
            /* ->add('categoria', NumberType::class, [
                'label' => 'Categoría:',
                'label_attr' => ['class' => 'etiqueta', 'value' => '1'],
                'data' => '1'
            ]) */
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class
            ])
            ->add('fecha',DateType::class, [
                'widget' => 'single_text'])
            ->add('numVisualizaciones')
            ->add('numLikes')
            ->add('numDownloads')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Las contraseñas deben coincidir.',
                'required' => true,
                'first_options' => ['label' => 'Password', 'label_attr' => ['class' => 'etiqueta']],
                'second_options' => ['label' => 'Repetir Password', 'label_attr' => ['class' => 'etiqueta']],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Imagen::class,
        ]);
    }
}
