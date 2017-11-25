<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Services as Services;
use AppBundle\Entity\Site as Site;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
//        return $this->render('default/index.html.twig', array(
//            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
//        ));

//        $content = $this->get('templating')->render('AppBundle:layout.html.twig');
//
//        return new Response($content);

        $servicesRepository = $this->getDoctrine()->getRepository(Services::class);
        $services = $servicesRepository->findAll();

        $siteRepository = $this->getDoctrine()->getRepository(Site::class);
        $site = $siteRepository->findAll();


        return $this->render('AppBundle:default:index.html.twig', array(
            'services' => $services,
            'site' => $site
        ));
    }
}
