<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\EmailUnique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['constraints' => [
                new Email(
                    ['message' => 'Please enter a valid email address']
                ),
                new NotBlank(
                    ['message' => 'Please enter your email address.']
                ),
                new EmailUnique(),
            ]])
            ->add('password', PasswordType::class, ['constraints' => [
                new NotBlank(['message' => 'Please enter a password.']),
                new Length(['min' => 8, 'minMessage' => 'Your password must be at least {{ limit }} characters long.'])
            ]]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false,
        ]);
    }
}
