<?php 

namespace App\Controller\jobs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Job;
use App\Form\job\JobType;
use App\Manager\JobManager;

class JobCreateController extends AbstractController{

    public function __construct(
        private JobManager $jobManager,
    ) {
    }

    #[Route('/jobs/create', name: "job_create")]
    public function projectsCreatePage(Request $request): Response
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if($form->isSubmitted()  && $form->isValid()){
            $this->addFlash('success', 'Le métier a été créée avec succès !');
            $this->jobManager->save($job);
            return $this->redirectToRoute('jobs', [
                'page' => 0
            ]);
        }


        return $this->render('pages/jobs/jobs_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}