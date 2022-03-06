<?php 

namespace App\Form\assigned;

use App\Entity\Assigned;
use App\Entity\Project;
use App\Entity\Employee;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class AssignedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('time_production', IntegerType::class, ['label' => 'Coût de production'])
            ->add('project', EntityType::class, [
                'class' => Project::class,
                'label' => 'Projet',
                'choice_label' => 'name',
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class' => Assigned::class,
        ]);
    }
}