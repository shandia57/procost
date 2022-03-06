<?php 

namespace App\Controller\employees;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Manager\EmployeeManager;


class EmployeeCreateController extends AbstractController{

    public function __construct( private EmployeeManager $employeeManager)
    {
        
    }

    #[Route('/employees/create', name: "employees_create", methods: ['POST', 'GET'])]
    public function employeesCreatePage(Request $request): Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if($form->isSubmitted()  && $form->isValid()){
            $this->addFlash('success', 'L\'employée a été créée avec succès !');
            $this->employeeManager->save($employee);
            return $this->redirectToRoute('employees', [
                'page' => 0,
            ]);
        }


        return $this->render('pages/employees/employee_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}