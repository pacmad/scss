<?php
namespace SCSS\FacilityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use SCSS\FacilityBundle\Entity\Quarters;
use SCSS\FacilityBundle\Form\Type\QuartersType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class QuartersController extends Controller
{
    /**
     * @Route("/", name="scss_quarters_index")
     * @Template("SCSSFacilityBundle:Quarters:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('SCSSFacilityBundle:Quarters')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'quarterss' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="scss_quarters_show")
     * @Template("SCSSFacilityBundle:Quarters:show.html.twig")
     */
    public function showAction($slug)
    {
        $quarters = $this->getDoctrine()
            ->getRepository('SCSSFacilitybundle:Quarters')
            ->findOneBySlug($slug);

        if (!$quarters) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching quarters found.'
                );
            $this->redirect($this->generateUrl('scss_quarters_index'));
        }

        return array('quarters' => $quarters);
    }

    /**
     * @Route("/new", name="scss_quarters_new")
     * @Template("SCSSFacilitybundle:Quarters:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $quarters = new Quarters();
        $form = $this->createForm(new QuartersType(), $quarters);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($quarters);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'quarters created.'
                );

                return $this->render(
                    'SCSSFacilitybundle:Quarters:show.html.twig',
                    array(
                        'quarters' => $quarters
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
