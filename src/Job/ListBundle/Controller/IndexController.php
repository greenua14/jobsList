<?php

namespace Job\ListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Job\ListBundle\Entity\Job;

class IndexController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction()
    {
        $jobs = $this->get('job.repository')->findAll();

        return array(
            'jobs' => $jobs
        );
    }

    /**
     * @param $slug
     * @return array
     * @Template()
     */
    public function showAction($slug)
    {
        $job = $this->get('job.repository')->findBy(array(
                'slug' => $slug
        ));

        return array(
            'job' => $job
        );
    }

    /**
     * @Template()
     */
    public function addAction(Request $request)
    {
        $job = new Job();
        $formType = $this->get('job.form.type');
        $form = $this->createForm($formType, $job);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            return $this->redirect($this->generateUrl(
                'index'
            ));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Template()
     */
    public function updateAction($id, Request $request)
    {
        $job = $this->get('job.repository')->find($id);
        $formType = $this->get('job.form.type');
        $form = $this->createForm($formType, $job);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl(
                'show_job', array('slug' => $job->getSlug())
            ));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Template()
     */
    public function deleteAction($id)
    {
        $job = $this->get('job.repository')->find($id);

        if($job)
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($job);
            $em->flush();

            return $this->redirect($this->generateUrl(
                'index'
            ));
        }

        return new Response('No advert');
    }
}
