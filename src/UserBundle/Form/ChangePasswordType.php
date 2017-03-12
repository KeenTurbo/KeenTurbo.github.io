<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use UserBundle\Entity\User;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class ChangePasswordType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('current_password', PasswordType::class, [
            'label'       => '旧密码',
            'mapped'      => false,
            'constraints' => new UserPassword([
                'message' => '旧密码不正确',
                'groups'  => ['change_password']
            ])
        ])->add('plainPassword', PasswordType::class, [
            'label' => '新密码'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => User::class,
            'validation_groups' => ['change_password']
        ]);
    }
}