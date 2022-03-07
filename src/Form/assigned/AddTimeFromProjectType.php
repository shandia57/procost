<?php 

namespace App\Form\assigned;

use App\Entity\Assigned;
use App\Entity\Employee;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class AddTimeFromProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('time_production', IntegerType::class, ['label' => 'Temps de production'])
            ->add('employee', EntityType::class, [
                'class' => Employee::class,
                'label' => 'Employé',
                'choice_label' => function(?Employee $employee) {
                    $fullname = $employee->getId()  .". " .$employee->getFirstname() ." "  .$employee->getLastname();
                    return $employee ? $fullname  : '';
            }
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