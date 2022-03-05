<?php 

namespace App\Controller\projects;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Manager\ProjectManager;


class ProjectCreateController extends AbstractController{

    public function __construct(
        private ProjectManager $projectManager,
    ) {
    }

    #[Route('/projects/create', name: "project_create", methods: ['POST', 'GET'])]
    public function projectsCreatePage(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted()  && $form->isValid()){
            $this->addFlash('success', 'Le projet a été créée avec succès !');
            $this->projectManager->save($project);
            return $this->redirectToRoute('projects');
        }

        return $this->render('pages/projects/project_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

