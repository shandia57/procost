<?php 

namespace App\Controller\projects;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProjectRepository;
use App\Repository\AssignedRepository;
use App\Form\ProjectType;
use App\Manager\ProjectManager;

class ProjectDetailsController extends AbstractController{
    private $date;
    public function __construct( 
        private ProjectRepository $projectRepo,
        private AssignedRepository $assignedRepo,
        private ProjectManager $projectManager,
    )
    {
        $this->date = new \DateTime('now');
    }

    #[Route('/projects/details/{id}', name: "project_details")]
    public function projectsDetailsPage(int $id, Request $request): Response
    {
        $project = $this->projectRepo->find($id);

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted()  && $form->isValid()){
            $project->setDelivery($this->date);
            $this->addFlash('success', 'Le projet est livré!');
            $this->projectManager->save($project);
        }


        $allAssigned = $this->assignedRepo->findAssignedPerProject($id);
        $numberEmployee = $this->assignedRepo->countNumberEmployeeSingleProject($id);
        $costProduction = $this->assignedRepo->costProductionSingleProject($id);
        $timeProduction = $this->assignedRepo->sumTimeProductionPerProject($id);
        $projectCost =  $this->assignedRepo->getProjectCostProduction($id);

        return $this->render('pages/projects/project_details.html.twig', [
            'project' => $project,
            'assigned' => $allAssigned,
            'numberEmployee' => $numberEmployee[0],
            'costProduction' => $costProduction[0],
            'timeProduction' => $timeProduction[0],
            'projectCost' => $projectCost[0],
            'form' => $form->createView(),
        ]);

    }
}