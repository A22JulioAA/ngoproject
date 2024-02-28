<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\Organization;
use App\Repository\OfferRepository;
use App\Repository\OrganizationRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route("/", name: "homepage")]
    public function homepage(): Response
    {



        return $this->render("main/homepage.html.twig", [
            "title" => "Homepage"
        ]);
    }

    #[Route("/add-offer", name: "addOffer")]
    public function add_offer(Request $request, OfferRepository $offerRepository): Response
    {

        $offer = new Offer();
        $form = $this->createFormBuilder($offer)
            ->add("title", null, [
                "label" => "Title: ",
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add("description", null, [
                "label" => "Description: ",
                "attr" => [
                    "rows" => 10,
                    "cols" => 40,
                    "class" => "input"
                ]
            ])
            ->add("init_date", null, [
                "label" => "Init Date:",
                "attr" => [
                    "class" => "inputTime"
                ]
            ])
            ->add("finish_date", null, [
                "label" => "Finish Date:",
                "attr" => [
                    "class" => "inputTime"
                ]
            ])
            ->add("vacancy", null, [
                "label" => "Vacancies:",
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add("id_organization", EntityType::class, [
                "class" => Organization::class,
                "choice_label" => "name",
                "label" => "Organization:",
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add("termsAndConditions", CheckboxType::class, [
                "mapped" => false,
                "label" => "I have read and accept all terms and conditions.",
                "required" => true
            ])
            ->add("submit", SubmitType::class, ["label" => "Add"])
            ->getForm();

        $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $post = $form->getData();
        //     // $offerRepository->add($post, true);

        //     // $this->addFlash("success", "Offer has been added");
        //     // return $this->redirectToRoute("homepage");
        // }

        return $this->render("/main/addOffer.html.twig", [
            "title" => "Add Offer",
            "form" => $form
        ]);
    }

    #[Route("add-organization", name: "addOrganization")]
    public function add_organization(EntityManagerInterface $entityManager): Response
    {
        $organization = new Organization;
        $organization->setName("Médicos sin Fronteras");
        $organization->setDescription("New ONG");
        $organization->setEmail("medicosSinFonteras@gmail.com");
        $organization->setPhone(null);
        $organization->setAddress("Fontiñas");
        $organization->setCountry("Spain");
        $organization->setCreatedAt(new \DateTimeImmutable());
        $organization->setLastUpdate(new \DateTimeImmutable());

        $entityManager->persist($organization);
        $entityManager->flush();

        return new Response(sprintf(
            "Organization %d with name '%s'created",
            $organization->getId(),
            $organization->getName()
        ));
    }
}
