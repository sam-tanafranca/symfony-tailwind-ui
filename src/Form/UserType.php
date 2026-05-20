<?php

namespace App\Form;

use App\Entity\UserEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isEdit = $options['is_edit'] ?? false;

        $builder
            ->add('username', TextType::class, [
                'label' => 'Username',
                'attr' => [
                    'placeholder' => 'Enter unique username',
                    'class' => 'w-full px-4 py-2.5 bg-[#fcfcfc] border border-zinc-200 rounded-[10px] text-[14px] outline-none focus:border-[#a855f7] focus:ring-1 focus:ring-[#a855f7] transition-all'
                ],
                'label_attr' => ['class' => 'block text-[13px] font-medium text-zinc-700 mb-1.5']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email Address',
                'attr' => [
                    'placeholder' => 'you@example.com',
                    'class' => 'w-full px-4 py-2.5 bg-[#fcfcfc] border border-zinc-200 rounded-[10px] text-[14px] outline-none focus:border-[#a855f7] focus:ring-1 focus:ring-[#a855f7] transition-all'
                ],
                'label_attr' => ['class' => 'block text-[13px] font-medium text-zinc-700 mb-1.5']
            ]);

        // Only add password field if we're not editing, OR make it optional in edit
        if (!$isEdit) {
            $builder->add('password', PasswordType::class, [
                'label' => 'Password',
                'mapped' => true,
                'constraints' => [
                    new NotBlank(
                        message: 'Please enter a password'
                    ),
                    new Length(
                        min: 6,
                        minMessage: 'Your password should be at least {{ limit }} characters',
                        max: 4096
                    ),
                ],
                'attr' => [
                    'placeholder' => '••••••••',
                    'class' => 'w-full px-4 py-2.5 bg-[#fcfcfc] border border-zinc-200 rounded-[10px] text-[14px] outline-none focus:border-[#a855f7] focus:ring-1 focus:ring-[#a855f7] transition-all'
                ],
                'label_attr' => ['class' => 'block text-[13px] font-medium text-zinc-700 mb-1.5']
            ]);
        } else {
            $builder->add('password', PasswordType::class, [
                'label' => 'Password (leave blank to keep current password)',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'placeholder' => '••••••••',
                    'class' => 'w-full px-4 py-2.5 bg-[#fcfcfc] border border-zinc-200 rounded-[10px] text-[14px] outline-none focus:border-[#a855f7] focus:ring-1 focus:ring-[#a855f7] transition-all'
                ],
                'label_attr' => ['class' => 'block text-[13px] font-medium text-zinc-700 mb-1.5']
            ]);
        }

        $builder
            ->add('first_name', TextType::class, [
                'label' => 'First Name',
                'attr' => [
                    'placeholder' => 'John',
                    'class' => 'w-full px-4 py-2.5 bg-[#fcfcfc] border border-zinc-200 rounded-[10px] text-[14px] outline-none focus:border-[#a855f7] focus:ring-1 focus:ring-[#a855f7] transition-all'
                ],
                'label_attr' => ['class' => 'block text-[13px] font-medium text-zinc-700 mb-1.5']
            ])
            ->add('last_name', TextType::class, [
                'label' => 'Last Name',
                'attr' => [
                    'placeholder' => 'Doe',
                    'class' => 'w-full px-4 py-2.5 bg-[#fcfcfc] border border-zinc-200 rounded-[10px] text-[14px] outline-none focus:border-[#a855f7] focus:ring-1 focus:ring-[#a855f7] transition-all'
                ],
                'label_attr' => ['class' => 'block text-[13px] font-medium text-zinc-700 mb-1.5']
            ])
            ->add('old_sys_id', TextType::class, [
                'label' => 'Old System ID',
                'required' => false,
                'attr' => [
                    'placeholder' => 'e.g. 1042',
                    'class' => 'w-full px-4 py-2.5 bg-[#fcfcfc] border border-zinc-200 rounded-[10px] text-[14px] outline-none focus:border-[#a855f7] focus:ring-1 focus:ring-[#a855f7] transition-all'
                ],
                'label_attr' => ['class' => 'block text-[13px] font-medium text-zinc-700 mb-1.5']
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'System Roles',
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Manager' => 'ROLE_MANAGER',
                    'Administrator' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true, // renders checkboxes
                'choice_attr' => [
                    'class' => 'w-4 h-4 text-purple-600 border-zinc-300 rounded focus:ring-purple-500 bg-white transition-colors cursor-pointer'
                ],
                'label_attr' => ['class' => 'block text-[13px] font-medium text-zinc-700 mb-1.5'],
            ])
            ->add('roles_allowed', ChoiceType::class, [
                'label' => 'Allowed Roles (Granting Permissions)',
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Manager' => 'ROLE_MANAGER',
                    'Administrator' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true,
                'choice_attr' => [
                    'class' => 'w-4 h-4 text-purple-600 border-zinc-300 rounded focus:ring-purple-500 bg-white transition-colors cursor-pointer'
                ],
                'label_attr' => ['class' => 'block text-[13px] font-medium text-zinc-700 mb-1.5'],
            ])
            ->add('types', ChoiceType::class, [
                'label' => 'User Types',
                'choices' => [
                    'Standard' => 'standard',
                    'System' => 'system',
                    'API User' => 'api',
                ],
                'multiple' => true,
                'expanded' => true,
                'choice_attr' => [
                    'class' => 'w-4 h-4 text-purple-600 border-zinc-300 rounded focus:ring-purple-500 bg-white transition-colors cursor-pointer'
                ],
                'label_attr' => ['class' => 'block text-[13px] font-medium text-zinc-700 mb-1.5'],
            ]);

        // Toggle Switch / Checkbox fields
        $booleans = [
            'is_active' => 'Is Active / Enabled',
            'is_access_all_company' => 'Access All Companies',
            'is_access_all_branch' => 'Access All Branches',
            'is_access_all_b_u' => 'Access All Business Units',
            'is_access_all_division' => 'Access All Divisions',
            'is_access_all_dept' => 'Access All Departments',
            'is_access_all_dept_unit' => 'Access All Department Units',
            'is_access_all_emp_type' => 'Access All Employee Types',
        ];

        foreach ($booleans as $field => $label) {
            $builder->add($field, CheckboxType::class, [
                'label' => $label,
                'required' => false,
                'attr' => [
                    'class' => 'w-4 h-4 text-purple-600 border-zinc-300 rounded focus:ring-purple-500 bg-white transition-colors cursor-pointer'
                ],
                'label_attr' => ['class' => 'ml-2 text-[14px] text-zinc-700 select-none cursor-pointer']
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserEntity::class,
            'is_edit' => false,
        ]);
    }
}
