<?php 

namespace App\Controller\employees;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\EmployeeRepository;
use App\Form\employee\EmployeeType;
use App\Manager\EmployeeManager;

class EmployeeUpdateController extends AbstractController{

    public function __construct( 
        private EmployeeRepository $employeeRepo, 
        private EmployeeManager $employeeManager,
    )
    {
        
    }

    #[Route('/employees/update/{id}', name: "employees_update")]
    public function employeesDetailsPage(int $id, Request $request): Response
    {
        $employee = $this->employeeRepo->find($id);
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if($form->isSubmitted()  && $form->isValid()){
            $this->addFlash('success', 'L\'employée a été modifié avec succès !');
            $this->employeeManager->save($employee);
            return $this->redirectToRoute('employees', [
                'page' => 0,
            ]);
        }

        return $this->render('pages/employees/employee_form.html.twig', [
            'employee' => $employee, 
            'form' => $form->createView(),
        ]);
    }
}