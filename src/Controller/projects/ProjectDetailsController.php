<?php 

namespace App\Controller\projects;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use App\Entity\Assigned;
use App\Manager\AssignedManager;
use App\Repository\ProjectRepository;
use App\Repository\AssignedRepository;
use App\Manager\ProjectManager;

use App\Form\projects\DeleteProjectType;
use App\Form\projects\FinishProjectType;
use App\Form\assigned\AddTimeFromProjectType;


class ProjectDetailsController extends AbstractController{
    private $date;
    public function __construct( 
        private ProjectRepository $projectRepo,
        private AssignedRepository $assignedRepo,
        private ProjectManager $projectManager,
        private AssignedManager $assignedManager,
    )
    {
        $this->date = new \DateTime('now');
    }

    #[Route('/projects/details/{id}?page={page}', name: "project_details")]
    public function projectsDetailsPage(int $id,int $page, Request $request): Response
    {
        $project = $this->projectRepo->find($id);
        if($project === null)
        {
            throw new NotFoundHttpException('project '.$id.' not found!');
        }

        // Form : delete the current project
        $formDelete = $this->createForm(DeleteProjectType::class, $project);
        $formDelete->handleRequest($request);
        if($formDelete->isSubmitted()  && $formDelete->isValid()){
            $this->addFlash('success', 'Le projet a été supprimé!');
            $this->projectRepo->remove($project);
            return $this->redirectToRoute('projects', [
                'page' => 0,
            ]);
        }

        // Form : Done the current project
        $formFinish = $this->createForm(FinishProjectType::class, $project);
        $formFinish->handleRequest($request);
        if($formFinish->isSubmitted()  && $formFinish->isValid()){
            $project->setDelivery($this->date);
            $this->projectManager->save($project);
            $this->addFlash('success', 'Le projet est livré!');
            
        }

        // Form : Add new time for this project
        $assigned = new Assigned();
        $assigned->setProject($project);
        
        $formAddTime = $this->createForm(AddTimeFromProjectType::class, $assigned);
        $formAddTime->handleRequest($request);

        if($formAddTime->isSubmitted()  && $formAddTime->isValid()){
            if($assigned->getProject()->getDelivery() != null){
                $this->addFlash('danger', 'Ce projet est terminé, vous ne pouvez plus ajouté du temps supplémentaire !');
            }else{
                $this->addFlash('success', 'Du temps a été ajouté avec succès !');
                $this->assignedManager->save($assigned);
            }
        }



        $allAssigned = $this->assignedRepo->findAssignedPerProject($id);
        $newArray = array_chunk($allAssigned,10);
        $numberEmployee = $this->assignedRepo->countNumberEmployeeSingleProject($id);
        $costProduction = $this->assignedRepo->costProductionSingleProject($id);
        $timeProduction = $this->assignedRepo->sumTimeProductionPerProject($id);
        $projectCost =  $this->assignedRepo->getProjectCostProduction($id);

        return $this->render('pages/projects/project_details.html.twig', [
            'project' => $project,
            'assigned' => $newArray[$page]??null,
            'numberEmployee' => $numberEmployee,
            'costProduction' => $costProduction,
            'timeProduction' => $timeProduction,
            'projectCost' => $projectCost,
            'formDelete' => $formDelete->createView(),
            'formFinish' => $formFinish->createView(),
            'formAddTime' => $formAddTime->createView(),
            "numberPage" =>$newArray,
            "currentPage" => $page + 1,
            'id' => $id,
            "page" => $page,
            "minPage" => 0,
            "maxPage" => count($newArray) ,
        ]);

    }
}