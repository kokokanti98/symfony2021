<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use App\Entity\Topic;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'constraints' => [
                    // Règle dont le champ ne doit pas être vide va afficher un message
                    new NotBlank([
                        'message' => 'Veuillez entrer votre message',
                    ]),
                ],
            ])
            ->add('creationDate')
            ->add('author', EntityType::class, [
                // Bien préciser la classe dont on parle vis à vis du champ
                'class' => User::class,
                'constraints' => [
                    // Règle dont le champ ne doit pas être vide va afficher un message
                    new NotBlank([
                        'message' => 'Veuillez entrer votre auteur',
                    ]),
                ],
            ])
            ->add('topic', EntityType::class, [
                // Bien préciser la classe dont on parle vis à vis du champ
                'class' => Topic::class,
                'constraints' => [
                    // Règle dont le champ ne doit pas être vide va afficher un message
                    new NotBlank([
                        'message' => 'Veuillez entrer votre sujet de discussion',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
