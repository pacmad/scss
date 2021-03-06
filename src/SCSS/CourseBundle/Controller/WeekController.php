<?php
namespace SCSS\CourseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use SCSS\CourseBundle\Entity\Week;
use SCSS\CourseBundle\Form\Type\WeekType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class WeekController extends Controller
{
    /**
     * @Route("/", name="scss_week_index")
     * @Template("SCSSCourseBundle:Week:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('SCSSCourseBundle:Week')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'weeks' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="scss_week_show")
     * @Template("SCSSCourseBundle:Week:show.html.twig")
     */
    public function showAction($slug)
    {
        $week = $this->getDoctrine()
            ->getRepository('SCSSCoursebundle:Week')
            ->findOneBySlug($slug);

        if (!$week) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching week found.'
                );
            $this->redirect($this->generateUrl('scss_week_index'));
        }

        return array('week' => $week);
    }

    /**
     * @Route("/new", name="scss_week_new")
     * @Template("SCSSCoursebundle:Week:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $week = new Week();
        $form = $this->createForm(new WeekType(), $week);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($week);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'week created.'
                );

                return $this->render(
                    'SCSSCoursebundle:Week:show.html.twig',
                    array(
                        'week' => $week
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
