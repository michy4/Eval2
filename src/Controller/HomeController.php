<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/home", name="home")
     */
    public function getClient()
    {
        $repository = $this->getDoctrine()->getRepository(Client::class);

        $clients = $repository->findAll();

        return $this->render('home/index.html.twig', [
            "clients" => $clients,
        ]);
    }

    /**
     * @Route("/home/supprimer", name="home")
     */
    public function supprimerClient(Request $request, $IBAN)
    {
        $repository = $this->getDoctrine()->getRepository(Client::class);
        $client = $repository->find($IBAN);

        $formulaire = $this->createFormBuilder()
            ->add("submit", SubmitType::class, ["label" =>"OK", "attr"=>["class"=>"btn btn-success"]])
            ->getForm();

        $formulaire->handleRequest($request);

        if($formulaire->isSubmitted() && $formulaire->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->remove($client);

            $em->flush();
        }

        return $this->render('home/index.html.twig', [
            "clients" => $clients,
        ]);
    }
}
