<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class CategoriesController extends Controller
{
    public function ShowCategoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Categories')->findBy(array('active' => '1'));

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $response = new Response($serializer->serialize($categories, 'json'));

        return $response;
    }

    public function ShowCategoriesOneAction($user_id)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Categories')->findBy(array('user_id'=>$user_id));

        if(!$categories)
        {
            $response = new Response($serializer->serialize(array('message'=>'false'), 'json'));
            return $response;
        }

        $response = new Response($serializer->serialize($categories, 'json'));

        return $response;
    }

    public function AddCategoriesAction($name,$user_id)
    {
        $categories = new Categories();
        $date = new \DateTime("now");

        $categories->setName($name);
        $categories->setUserId($user_id);
        $categories->setActive(1);
        $categories->setUserId($user_id);
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

    public function UpdateCategoriesAction($categorie_id, $name)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $date = new \DateTime("now");
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Categories')->find($categorie_id);

        if(!$categories)
        {
            $response = new Response($serializer->serialize(array('message'=>'false'), 'json'));
            return $response;
        }

        $categories->setName($name);
        $categories->setUpdatedAt($date);
        $em->flush();

        $response = new Response($serializer->serialize(array('message'=>'true'), 'json'));

        return $response;
    }

    public function DeleteCategoriesAction($categorie_id)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Categories')->find($categorie_id);

        if(!$categories)
        {
            $response = new Response($serializer->serialize(array('message'=>'false'), 'json'));
            return $response;
        }

        $tasks = $em->getRepository('AppBundle:Tasks')->findBy(array('categorie_id' => $categorie_id));

        foreach ($tasks as $value) {
            $value->setActive(0);
            $em->persist($value);
        }

        $categories->setActive(0);
        $em->flush();

        $response = new Response($serializer->serialize(array('message'=>'true'), 'json'));

        return $response;
    }

}
