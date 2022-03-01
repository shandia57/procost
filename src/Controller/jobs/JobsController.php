<?php 

namespace App\Controller\jobs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\JobRepository;

class JobsController extends AbstractController{

    public function __construct( private JobRepository $jobRepo)
    {
        
    }

    #[Route('/jobs', name: "jobs")]
    public function projectsPage(): Response
    {
        $jobs = $this->jobRepo->findAll();
        return $this->render('pages/jobs/jobs.html.twig', [
            'jobs' => $jobs,
        ]);
    }
}