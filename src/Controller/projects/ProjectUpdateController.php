<?php 

namespace App\Controller\projects;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Entity\Project;
use App\Form\project\ProjectType;
use App\Manager\ProjectManager;
use App\Repository\ProjectRepository;


class ProjectUpdateController extends AbstractController{

    public function __construct( 
        private ProjectRepository $projectRepo, 
        private ProjectManager $projectManager,
        )
    {
        
    }

    #[Route('/projects/update/{id}', name: "project_update")]
    public function projectsUpdatePage(int $id, Request $request): Response
    {
        $project = $this->projectRepo->find($id);
        if($project === null)
        {
            throw new NotFoundHttpException('project '.$id.' not found!');
        }


        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted()  && $form->isValid()){
            if($project->getDelivery() != null){
                $this->addFlash('danger', 'Vous ne pouvez faire aucune action lorsqu\'un projet est livré');
            }else{
                $this->addFlash('success', 'Le projet a correctement modifié !');
                $this->projectManager->save($project);
                return $this->redirectToRoute('projects', [
                    'page' => 0
                ] );
            }
            
        }
        return $this->render('pages/projects/project_form.html.twig', [
            'project' => $project,
            'form' => $form->createView(),

        ]);

    }
}