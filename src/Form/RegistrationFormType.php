<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        // ajout des différentes cases de notre formulaires
            ->add('email')
            ->add('firstname')
            ->add('lastname')
            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'Editeur' => 'ROLE_EDITOR',
                    'Admnistrateur' => 'ROLE_ADMIN',
                    'Utilisateur' => 'ROLE_USER',
                ],
                'expanded' => true,
                //Liste à selection multiple avec le expanded en true y aura des cases à cocher
                'multiple' => true,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez acepter nos conditions d utilisation.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    // Règle dont le champ mdp ne doit pas être vide va afficher un message
                    new NotBlank([
                        'message' => 'Veuillze entrez un mot de passe',
                    ]),
                    // Règle de Taille du mot de passe
                    new Length([
                        'min' => 6,
                        'minMessage' => 'La taille de votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
