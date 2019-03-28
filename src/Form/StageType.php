<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('initule')
            ->add('descriptif', TextareaType::class)
            ->add('domaine')
            ->add('email')
            ->add('URL')
            ->add('entreprise', EntrepriseType::class)
            ->add('formations', EntityType::class, array(
                  'class' => Formation::class,
                  'choice_label' => 'intitule',
                  'multiple' => true,
                  'expanded' => true
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
