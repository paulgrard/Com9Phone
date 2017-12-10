<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Services as Services;
use AppBundle\Entity\Site as Site;
use AppBundle\Entity\Tariffs as Tariffs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $servicesRepository = $this->getDoctrine()->getRepository(Services::class);
        $services = $servicesRepository->findAll();

        $siteRepository = $this->getDoctrine()->getRepository(Site::class);
        $site = $siteRepository->findAll();

        $tariffsRepository = $this->getDoctrine()->getRepository(Tariffs::class);
        $tariffs = $tariffsRepository->findAll();

        $contact = new Contact();

        $form = $this->createFormBuilder($contact)
            ->add('name', 'text', array(
                'attr' => array(
                    'placeholder' => 'Nom',
                ))
            )
            ->add('email', 'email', array(
                'attr' => array(
                    'placeholder' => 'Email',
                ))
            )
            ->add('object', 'text', array(
                    'attr' => array(
                        'placeholder' => 'Objet',

                    ),
                    'label' => 'Objet'
                )
            )
            ->add('message', 'textarea', array(
                    'attr' => array(
                        'placeholder' => 'Message',
                    ))
            )
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            die($contact);
            $message = (new \Swift_Message('Com9Phone Contact'))
                ->setFrom('send@example.com')
                ->setTo('recipient@example.com')
                ->setBody(
                    $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'Emails/registration.html.twig',
                        array('name' => $name)
                    ),
                    'text/html'
                )
                /*
                 * If you also want to include a plaintext version of the message
                ->addPart(
                    $this->renderView(
                        'Emails/registration.txt.twig',
                        array('name' => $name)
                    ),
                    'text/plain'
                )
                */
            ;

            $this->get('mailer')->send($message);

            $em = $this->getDoctrine()->getManager();
//            $em->persist($contact);
//            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Votre mail a bien été envoyé.');
        }

        return $this->render('AppBundle:default:index.html.twig', array(
            'services' => $services,
            'site' => $site,
            'tariffs' => $tariffs,
            'form' => $form->createView()
        ));
    }
}
