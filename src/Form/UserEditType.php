<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,[
                'attr' => [
                    'placeholder' => 'Email',

                ],
                'label'=>' E-mail',
                'required' => true
            ])
            ->add('name',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Name '
                ]
            ]) ->add('full_name',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Full name '
                ]
            ])
            ->add('job',TextType::class,[
                'attr'=>[
                    'placeholder'=>'job '
                ],

                'required' => false
            ])->add('adress',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Address '
                ]
            ])
            ->add('tel',IntegerType::class,[
                'attr'=>[
                    'placeholder'=>'Contact'
                ]
            ])

            //            ->add('roles')
//            ->add('password',PasswordType::class,[
//                'attr'=>[
//                    'placeholder'=>'Password '
//                ]
//            ])
            ->add('confirm_password',PasswordType::class,[
                'attr'=>[
                    'placeholder'=>'Password '
                ],
                'label'=>'Votre mots de pass pour confirmer le modification'
            ])
//            ->add('createdAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
