<?php 

namespace App\Controller\jobs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Job;
use App\Form\JobType;
use App\Manager\JobManager;
use App\Repository\JobRepository;

class JobUpdateController extends AbstractController{

    public function __construct(
        private JobManager $jobManager,
        private JobRepository $jobRepository
    ) {
    }

    #[Route('/jobs/update/{id}', name: "job_update")]
    public function projectsCreatePage(int $id, Request $request): Response
    {
        $job = $this->jobRepository->find($id);
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if($form->isSubmitted()  && $form->isValid()){
            $this->addFlash('success', 'Le métier a été modifié avec succès !');
            $this->jobManager->save($job);
            return $this->redirectToRoute('jobs');
        }


        return $this->render('pages/jobs/jobs_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}