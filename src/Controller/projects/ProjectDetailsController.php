<?php 

namespace App\Controller\projects;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProjectRepository;
use App\Repository\AssignedRepository;

class ProjectDetailsController extends AbstractController{

    public function __construct( 
        private ProjectRepository $projectRepo,
        private AssignedRepository $assignedRepo,
    )
    {
        
    }

    #[Route('/projects/details/{id}', name: "project_details")]
    public function projectsDetailsPage(int $id): Response
    {
        $project = $this->projectRepo->find($id);
        $allAssigned = $this->assignedRepo->findAssignedPerProject($id);
        $numberEmployee = $this->assignedRepo->countNumberEmployeeSingleProject($id);
        $costProduction = $this->assignedRepo->costProductionSingleProject($id);
        $timeProduction = $this->assignedRepo->sumTimeProductionPerProject($id);
        $totalCost = 0;
        return $this->render('pages/projects/project_details.html.twig', [
            'project' => $project,
            'assigned' => $allAssigned,
            'numberEmployee' => $numberEmployee[0],
            'costProduction' => $costProduction[0],
            'timeProduction' => $timeProduction[0],
            'totalPrice' => $totalCost,
        ]);

    }
}