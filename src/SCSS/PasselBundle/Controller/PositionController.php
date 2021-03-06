<?php
namespace SCSS\PasselBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use SCSS\PasselBundle\Entity\Position;
use SCSS\PasselBundle\Form\Type\PositionType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\View\TwitterBootstrapView;

class PositionController extends Controller
{
    /**
     * @Route("/", name="scss_position_index")
     * @Template("SCSSPasselBundle:Position:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('SCSSPasselBundle:Position')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'positions' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="scss_position_show")
     * @Template("SCSSPasselBundle:Position:show.html.twig")
     */
    public function showAction( $slug )
    {
        $position = $this->getDoctrine()
            ->getRepository('SCSSPasselbundle:Position')
            ->findOneBySlug($slug);

        if (!$position) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching position found.'
                );
            $this->redirect($this->generateUrl('scss_position_index'));
        }

        return array('position' => $position);
    }


    /**
     * @Route("/new", name="scss_position_new")
     * @Template("SCSSPasselbundle:Position:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $position = new Position();
        $form = $this->createForm(new PositionType(), $position);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($position);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'position created.'
                );

                return $this->render(
                    'SCSSPasselbundle:Position:show.html.twig',
                    array(
                        'position' => $position
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
