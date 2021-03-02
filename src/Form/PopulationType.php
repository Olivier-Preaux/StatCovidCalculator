<?php

namespace App\Form;

use App\Entity\Population;
use Container0hzdZDR\getFosCkEditor_Form_TypeService;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class PopulationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class )
            ->add('firstName' , TextType::class )
            ->add('isVaccinatedFirstDose' )
            ->add('isVaccinatedSecondDose'  )
            ->add('observations' , CKEditorType::class )
            ->add('doctor')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Population::class,
        ]);
    }
}
