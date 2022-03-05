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
        $fiveLastProject = $this->projectRepository->getProjectCostProduction();
        



        

        return $this->render('home.html.twig', [
            'progress' => $projectsInProgress[0],
            'done' => $projectsDone[0],
            'numberEmployees' => $numberEmployees[0],
            'dayProduction' => $numberProduction[0],
            'sixEmployee' => $sixLastEmployee,
            'fiveProject' =>  $fiveLastProject,


        ]);
    }
}