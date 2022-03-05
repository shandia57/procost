<?php 

namespace App\Controller\employees;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Assigned;
use App\Form\AssignedType;
use App\Manager\AssignedManager;

use App\Repository\EmployeeRepository;
use App\Repository\AssignedRepository;

class EmployeeDetailsController extends AbstractController{
    public function __construct( 
        private EmployeeRepository $employeeRepo,
        private AssignedRepository $assignedRepo,
        private AssignedManager $assignedManager,
    )
    {
        
    }

    #[Route('/employees/details/{id}', name: "employees_details")]
    public function employeesDetailsPage(int $id, Request $request): Response
    {
        $employee = $this->employeeRepo->find($id);
        $allAssigned = $this->assignedRepo->findAssignedPerEmployee($id);
        $assigned = new Assigned();
        $assigned->setEmployee($employee);

        $form = $this->createForm(AssignedType::class, $assigned);
        $form->handleRequest($request);

        if($form->isSubmitted()  && $form->isValid()){

            if($assigned->getProject()->getDelivery() != null){
                $this->addFlash('danger', 'Ce projet est terminé, vous ne pouvez plus ajouté du temps supplémentaire !');
            }else{
                $this->addFlash('success', 'Du temps a été ajouté avec succès !');
                $this->assignedManager->save($assigned);
            }
            
        }

        $fullname = "  ";

        return $this->render('pages/employees/employees_details.html.twig', [
            'employee' => $employee, 
            'form' => $form->createView(),
            'assigned' => $allAssigned,
            'fullname' => $fullname,
        ]);
    }
}