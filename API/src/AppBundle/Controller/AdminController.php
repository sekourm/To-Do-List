<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categories;
use AppBundle\Entity\Tasks;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class AdminController extends Controller
{
    public function AddCategoriesAction($name, $user_id, $admin_id)
    {
        $categories = new Categories();
        $date = new \DateTime("now");

        $categories->setName($name);
        $categories->setUserId($user_id);
        $categories->setActive(1);
        $categories->setUserId($user_id);
        $categories->setAdminId($admin_id);
        $categories->setCreatedAt($date);
        $categories->setUpdatedAt($date);
        $em = $this->getDoctrine()->getManager();
        $em->persist($categories);
        $em->flush();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response($serializer->serialize(array('message'=>'true'), 'json'));

        return $response;
    }

    public function AddTasksAction($categorie_id, $admin_id, $title, $description)
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
        $tasks->setAdminId($admin_id);
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

}
