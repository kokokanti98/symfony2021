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
            ->add('email', EmailType::class, [
                'constraints' => [
                    // Règle dont le champ ne doit pas être vide va afficher un message
                    new NotBlank([
                        'message' => 'Veuillez entrer un adresse email valide',
                    ]),
                    // Règle de Taille du champ
                    new Length([
                        //valeur minimum
                        'min' => 18,
                        'minMessage' => 'Votre adrese email doit au moins contenir {{ limit }} caractères',
                        //valeur max prise
                        'max' => 150,
                    ]),
                ],
            ])
            ->add('firstname', TextType::class, [
                'constraints' => [
                    // Règle dont le champ ne doit pas être vide va afficher un message
                    new NotBlank([
                        'message' => 'Veuillez entrer votre prenom',
                    ]),
                    // Règle de Taille du champ
                    new Length([
                        //valeur minimum
                        'min' => 2,
                        'minMessage' => 'Votre prenom doit au moins contenir {{ limit }} caractères',
                        //valeur max prise
                        'max' => 150,
                    ]),
                ],
            ])
            ->add('lastname' , TextType::class, [
                'constraints' => [
                    // Règle dont le champ ne doit pas être vide va afficher un message
                    new NotBlank([
                        'message' => 'Veuillez entrer votre nom',
                    ]),
                    // Règle de Taille du champ
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre nom de famille doit au moins contenir {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'choices'  => [
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
                  // Ce champ mot de passe ne sera pas lier directement sur l'objet en question(User),
                // il sera li et encoder dans le controller avant d'être lier
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    // Règle dont le champ mdp ne doit pas être vide va afficher un message
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    // Règle de Taille du mot de passe
                    new Length([
                        'min' => 6,
                        'minMessage' => 'La taille de votre mot de passe doit contenir au moins {{ limit }} caractères',
                        //valeur max que symfony autorise pour des mesures de sécurité
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
