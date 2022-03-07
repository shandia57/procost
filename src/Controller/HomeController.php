<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProjectRepository;
use App\Repository\AssignedRepository;
use App\Repository\EmployeeRepository;

class HomeController extends AbstractController{
    private $date;

    public function __construct(
        private ProjectRepository $projectRepository, 
        private AssignedRepository $assignedRepository,
        private EmployeeRepository $employeeRepository
        )
    {
        $this->date = new \DateTime('now');
    }



    #[Route('/', name: "home")]
    public function homePage(): Response
    {
        $projectsInProgress = $this->projectRepository->getNumberProjectInProgress();
        $projectsDone = $this->projectRepository->getNumberProjectDone();
        $numberEmployees = $this->employeeRepository->getNumberEmployee();
        $numberProduction = $this->assignedRepository->sumTotalTimeProduction();

        $sixLastEmployee = $this->employeeRepository->getSixLastEmployee();
        $fiveLastProject = $this->projectRepository->getAllProjectWithCostProduction();
        
        
        $projectDeliveried = $this->projectRepository->getAllProjectDelevereidWithCostProduction();
        $numberCostProject = 0;
        foreach($projectDeliveried as $project){
            if($project['price'] < $project['cost']){
                $numberCostProject ++;
            }
        }
        $profitabilityRate = 0;
        $deliveryRate = 0;
        if( $projectsDone['project'] != 0){
            $profitabilityRate =  $numberCostProject / $projectsDone['project'] * 100;
            $deliveryRate = round($projectsDone['project'] / ( $projectsDone['project'] + $projectsInProgress['project'] ) * 100, 0);

        }



        $employeesWithCostProduction = $this->employeeRepository->getEmployeesWithTotalCostProduction();
        $keynew = 0;
        if($employeesWithCostProduction != null){
            $maxValue = max(array_column($employeesWithCostProduction, 'cost'));
            
            foreach($employeesWithCostProduction as $key => $employee){
                if($employee['cost'] == $maxValue) $keynew = $key;
            }
        }


        return $this->render('home.html.twig', [
            'progress' => $projectsInProgress,
            'done' => $projectsDone,
            'numberEmployees' => $numberEmployees,
            'dayProduction' => $numberProduction,
            'sixEmployee' => $sixLastEmployee,
            'fiveProject' =>  $fiveLastProject,
            'deliveryRate' => $deliveryRate ,
            'cost' => $profitabilityRate,
            'topEmployee' => $employeesWithCostProduction[$keynew]??null,

        ]);
    }
}