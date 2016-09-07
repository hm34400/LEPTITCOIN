<?php

namespace SiteInternetBundle\Controller;

use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SiteInternetBundle\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class AnnonceController extends Controller
{
    /**
     * @Route("/annonce", name="annonce")
     * @Template("SiteInternetBundle::annonce.html.twig") 
    */
    public function getAnnonce()
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $rsm = new ResultSetMappingBuilder($em);
        
        $rsm->addRootEntityFromClassMetadata('SiteInternetBundle:Annonce', 'coincoin');
        
        $query = $em->createNativeQuery("select * from annonce", $rsm);
        
        $annonce = $query->getResult();
        
        return array('annonce' => $annonce); 
    }
    /**
     * @Route("/annonce/add",name="form")
     * @Template("SiteInternetBundle::addAnnonce.html.twig")
     * @param Request $request
     */
    public function formAnnonce(Request $request) {
        $annonce = new Annonce();
        $formBuilder = $this->createFormBuilder($annonce);
        $formBuilder->add("Titre");
        $formBuilder->add("Image");
        $formBuilder->add("Description");
        $formBuilder->add("Prix");
        $formBuilder->add("Vendeur");
        $formBuilder->add("Date_de_parution");
        $formBuilder->add("Tel");
        $formBuilder->add("Categorie");
        $formBuilder->add("Localite");
        
        $formBuilder->add("save", SubmitType::class);
        $f =$formBuilder->getForm();
        return array("formAnnonce" => $f->createView());
        }
        /**
         *@Route("/annonce/valid",name = "valid")
         * @Template("SiteInternetBundle::annonce.html.twig")
         */
    public function addAnnonce(Request $request) {
        $annonce = new Annonce;
        $formBuilder = $this->createFormBuilder($annonce);
        $formBuilder->add("Titre");
        $formBuilder->add("Image");
        $formBuilder->add("Description");
        $formBuilder->add("Prix");
        $formBuilder->add("Vendeur");
        $formBuilder->add("Date_de_parution");
        $formBuilder->add("Tel");
        $formBuilder->add("Categorie");
        $formBuilder->add("Localite");
        $f = $formBuilder->getForm(); 
        
        if ($request->getMEthod() == 'POST'){
            $f->handleRequest($request);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($annonce);
            $em->flush();
            return $this->redirect($this->generateUrl('annonce'));
            }
        return $this->redirect($this->generateUrl('form'));
        }
        
}
