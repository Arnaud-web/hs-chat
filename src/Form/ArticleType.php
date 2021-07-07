<?php

namespace App\Form;

use App\Entity\Article;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorie')
            ->add('titre')
            ->add('description')
            ->add('statu',CheckboxType::class, [
                'label'    => 'Publier ?',
                'required' => false,
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'label'=> false,
            ])
//            ->add('userCreated')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
