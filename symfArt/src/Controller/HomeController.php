<?php 

namespace App\Controller;

use App\Entity\Tasks;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;

class HomeController extends AbstractController
{
	/**
	 * @Route("/", name="home")
	 */
	public function index(ManagerRegistry $doctrine, Request $request) {
		$tasks = $doctrine->getRepository(Tasks::class)->findAll();
		
		return $this->render("index.html.twig", ['tasks' => $tasks]);
	}

	/**
	 * @Route("/save", name="save", methods={"POST"})
	 */
	public function store(ManagerRegistry $doctrine, Request $request) {
		$entityManager = $doctrine->getManager();

		$body = $request->get('task');

		$task = new Tasks();
		$task->setBody($body);

		$entityManager->persist($task);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('home');
	}

	/** 
	 * @Route("/edit/{id}", name="edit", methods={"GET", "HEAD"})
	*/
	public function edit(ManagerRegistry $doctrine, $id) {
		$task = $doctrine->getRepository(Tasks::class)->find($id);
		return $this->render("edit.html.twig", ['task'=>$task]);
	}

	/** 
	 * @Route("/update/{id}", name="update", methods={"POST"})
	*/
	public function update(Request $request, ManagerRegistry $doctrine, $id) {
		$entityManager = $doctrine->getManager();
		$oldTask = $entityManager->getRepository(Tasks::class)->find($id);
		$task = $request->get('task');
		$oldTask->setBody($task);

		$entityManager->flush();
		return $this->redirectToRoute('home');
	}

	/**
	 * @Route("/destroy/{id}", name="destroy", methods={"GET"})
	 */
	public function destroy(Request $request, ManagerRegistry $doctrine, $id) {
		$entityManager = $doctrine->getManager();
		$oldTask = $entityManager->getRepository(Tasks::class)->find($id);
		$entityManager->remove($oldTask);

		$entityManager->flush();
		return $this->redirectToRoute('home');
	}
}