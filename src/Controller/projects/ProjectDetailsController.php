<?php 

namespace App\Controller\projects;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProjectRepository;
use App\Repository\AssignedRepository;
use App\Manager\ProjectManager;
use App\Form\projects\DeleteProjectType;
use App\Form\projects\FinishProjectType;

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

        $formDelete = $this->createForm(DeleteProjectType::class, $project);
        $formDelete->handleRequest($request);
        if($formDelete->isSubmitted()  && $formDelete->isValid()){
            $this->addFlash('success', 'Le projet a été supprimé!');
            $this->projectRepo->remove($project);
            return $this->redirectToRoute('projects');
        }

        $formFinish = $this->createForm(FinishProjectType::class, $project);
        $formFinish->handleRequest($request);
        if($formFinish->isSubmitted()  && $formFinish->isValid()){
            $project->setDelivery($this->date);
            $this->projectManager->save($project);
            $this->addFlash('success', 'Le projet est livré!');
            
        }




        $allAssigned = $this->assignedRepo->findAssignedPerProject($id);
        $numberEmployee = $this->assignedRepo->countNumberEmployeeSingleProject($id);
        $costProduction = $this->assignedRepo->costProductionSingleProject($id);
        $timeProduction = $this->assignedRepo->sumTimeProductionPerProject($id);
        $projectCost =  $this->assignedRepo->getProjectCostProduction($id);

        return $this->render('pages/projects/project_details.html.twig', [
            'project' => $project,
            'assigned' => $allAssigned,
            'numberEmployee' => $numberEmployee,
            'costProduction' => $costProduction,
            'timeProduction' => $timeProduction,
            'projectCost' => $projectCost,
            'formDelete' => $formDelete->createView(),
            'formFinish' => $formFinish->createView(),
        ]);

    }
}