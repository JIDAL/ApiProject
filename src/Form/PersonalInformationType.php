<?php

namespace App\Form;

use App\Entity\PersonalInformation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonalInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('full_name', TextType::class, ['required' => true])
            ->add('adresse', TextType::class, [ 'required' => true])
            ->add('personal_email', EmailType::class, ['required' => true])
            ->add('professional_email', EmailType::class, ['required' => true])
            ->add('phone', TextType::class, ['required' => true])
            ->add('job', TextType::class, ['required' => true])
            ->add('age', TextType::class, ['required' => true])
            ->add('web', TextType::class, ['required' => true])
            ->add('situation', TextareaType::class, ['required' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PersonalInformation::class,
            'validation_groups' => ['create']
        ]);
    }
}
