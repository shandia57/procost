<?php 

namespace App\Form\employee;

use App\Entity\Employee;
use App\Entity\Job;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('firstname', TextType::class, ['label' => 'Prénom'])
            ->add('lastname', TextType::class, ['label' => 'Nom'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('cost', IntegerType::class, ['label' => 'Coût journalier (en €)'])
            ->add('started_job', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
             ])

            ->add('job', EntityType::class, [
                'class' => Job::class,
                'label' => 'Métier',
                'choice_label' => 'name',
                
                ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}