<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\Organization;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route("/", name: "homepage")]
    public function homepage(OfferRepository $offerRepository): Response
    {

        $arrayOffers = $offerRepository->findAllByData();

        return $this->render("main/homepage.html.twig", [
            "title" => "Homepage",
            "arrayOffers" => $arrayOffers
        ]);
    }

    #[Route("/add-offer", name: "addOffer")]
    public function add_offer(Request $request, EntityManagerInterface $entityManager): Response
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
            ->add("submit", SubmitType::class, ["label" => "Add", "attr" => [
                "class" => "submitButton"
            ]])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash("success", "Offer has been added");
            return $this->redirectToRoute("homepage");
        }

        return $this->render("/main/addOffer.html.twig", [
            "title" => "Add Offer",
            "form" => $form
        ]);
    }

    #[Route("add-organization", name: "addOrganization")]
    public function add_organization(EntityManagerInterface $entityManager, Request $request): Response
    {
        $organization = new Organization();

        $form = $this->createFormBuilder($organization)
            ->add("name", null, [
                "label" => "Name: ",
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
            ->add("email", null, [
                "label" => "Email: ",
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add("phone", null, [
                "label" => "Phone:",
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add("address", null, [
                "label" => "Address:",
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add("country", null, [
                "label" => "Country:",
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add("termsAndConditions", CheckboxType::class, [
                "mapped" => false,
                "label" => "I have read and accept all terms and conditions.",
                "required" => true
            ])
            ->add("submit", SubmitType::class, ["label" => "Add", "attr" => [
                "class" => "submitButton"
            ]])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash("success", "Organization has been added");
            return $this->redirectToRoute("homepage");
        }

        return $this->render("/main/addOrganization.html.twig", [
            "title" => "Add Organization",
            "form" => $form
        ]);
    }

    #[Route("/send-flash-apply", name: "send_flash_apply")]
    public function sendFlashApply(): RedirectResponse
    {
        $this->addFlash("success", "Your request has been sent successfully!");

        return $this->redirectToRoute("homepage");
    }

    // This routes are not implemented.

    #[Route("/my-offers", name: "my-offers")]
    public function myOffers(): Response
    {
        return $this->render("/main/myOffers.html.twig", [
            "title" => "My Offers"
        ]);
    }

    #[Route("/my-profile", name: "my-profile")]
    public function myProfile(): Response
    {
        return $this->render("/main/myProfile.html.twig", [
            "title" => "My Profile"
        ]);
    }
}
