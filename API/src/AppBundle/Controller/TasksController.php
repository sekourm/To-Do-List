<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tasks;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\HttpFoundation\Response;

class TasksController extends Controller
{
    public function ShowTasksAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tasks = $em->getRepository('AppBundle:Tasks')->findBy(array('active' => '1'));

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $response = new Response($serializer->serialize($tasks, 'json'));

        return $response;
    }

    public function ShowOneTasksAction($task_id)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $em = $this->getDoctrine()->getManager();
        $tasks = $em->getRepository('AppBundle:Tasks')->findOneBy(array('id'=>$task_id));

        if(!$tasks)
        {
            $response = new Response($serializer->serialize(array('message'=>'false'), 'json'));
            return $response;
        }

        $response = new Response($serializer->serialize($tasks, 'json'));

        return $response;
    }

    public function ShowAllByUserAction($user_id)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:Profiles')->findBy(array('id' => $user_id));

        if(!$user)
        {
            $response = new Response($serializer->serialize(array('message'=>'false'), 'json'));
            return $response;
        }

        $tasks = $em->getRepository('AppBundle:Tasks')->findOneBy(array('user_id'=>$user_id));
        $response = new Response($serializer->serialize($tasks, 'json'));
        return $response;
    }

    public function AddTasksAction($categorie_id, $title, $description)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Categories')->findBy(array('id' => $categorie_id));

        if(!$categories)
        {
            $response = new Response($serializer->serialize(array('message'=>'false'), 'json'));
            return $response;
        }

        $tasks = new Tasks();
        $date = new \DateTime("now");
        $tasks->setTitle($title);
        $tasks->setDescription($description);
        $tasks->setCategorieId($categorie_id);
        $tasks->setCreatedAt($date);
        $tasks->setUpdatedAt($date);
        $tasks->setLimitDate($date);
        $tasks->setActive(1);
        $em->persist($tasks);
        $em->flush();

        $Alltasks = $em->getRepository('AppBundle:Tasks')->findBy(array('active' => '1'));
      //  $response = new Response($serializer->serialize($tasks, 'json'));
        $response = new Response($serializer->serialize(array('message'=>'true', $Alltasks), 'json'));

        return $response;
    }

    public function UpdateTasksAction($task_id, $categorie_id ,$title, $description)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $date = new \DateTime("now");
        $em = $this->getDoctrine()->getManager();
        $tasks = $em->getRepository('AppBundle:Tasks')->find($task_id);
        $categories = $em->getRepository('AppBundle:Categories')->findBy(array('id' => $categorie_id));

        if(!$tasks||!$categories)
        {
            $response = new Response($serializer->serialize(array('message'=>'false'), 'json'));
            return $response;
        }

        $tasks->setTitle($title);
        $tasks->setDescription($description);
        $tasks->setCategorieId($categorie_id);
        $tasks->setUpdatedAt($date);
        $em->flush();

        $response = new Response($serializer->serialize(array('message'=>'true'), 'json'));

        return $response;
    }

    public function DeleteTasksAction($task_id)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $em = $this->getDoctrine()->getManager();
        $tasks = $em->getRepository('AppBundle:Tasks')->find($task_id);

        if(!$tasks)
        {
            $response = new Response($serializer->serialize(array('message'=>'false'), 'json'));
            return $response;
        }

        $tasks->setActive(0);
        $em->flush();

        $response = new Response($serializer->serialize(array('message'=>'true'), 'json'));

        return $response;
    }
}
