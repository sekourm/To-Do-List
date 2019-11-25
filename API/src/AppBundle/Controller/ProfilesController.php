<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Profiles;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Filesystem\Filesystem;

class ProfilesController extends Controller
{
    public function ShowProfilesAction()
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Profiles')->findBy(array('active' => '1'));

        $response = new Response($serializer->serialize($categories, 'json'));
        return $response;
    }

    public function ShowProfilesOneAction($profile_id)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $em = $this->getDoctrine()->getManager();
        $profiles = $em->getRepository('AppBundle:Profiles')->findOneBy(array('id' => $profile_id));

        if (!$profiles) {
            $response = new Response($serializer->serialize(array('message' => 'false'), 'json'));
            return $response;
        }

        $response = new Response($serializer->serialize($profiles, 'json'));
        return $response;
    }

    public function AddProfilesAction(Request $request)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);


        $date = new \DateTime("now");
        $directoryPath = $this->container->getParameter('kernel.root_dir') . '/../web/picture/';
        $path = $directoryPath . 'anonymous.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $profiles = new Profiles();


        $post = $request->getContent();

        $post = json_decode($post);

        $name = $post->name;
        $lastname = $post->lastname;
        $password = $post->password;
        $email = $post->email;

        if (!isset($post->photo)) {
            $photo = 'data:image/' . $type . ';base64,' . base64_encode($data);

        } else {
            $photo = $post->photo;
        }

        $em = $this->getDoctrine()->getManager();
        $email_profiles = $em->getRepository('AppBundle:Profiles')->findOneBy(array('email' => $email));

        if ($email_profiles) {
            $response = new Response($serializer->serialize(array('message' => 'false'), 'json'));
            return $response;
        }

        $profiles->setName($name);
        $profiles->setLastname($lastname);
        $profiles->setPassword(md5($password));
        $profiles->setEmail($email);
        $profiles->setPhoto($photo);
        $profiles->setTheme('azure');
        $profiles->setActive(1);
        $profiles->setCreatedAt($date);
        $profiles->setUpdatedAt($date);
        $em = $this->getDoctrine()->getManager();
        $em->persist($profiles);
        $em->flush();

        $response = new Response($serializer->serialize(array('message' => 'true'), 'json'));
        return $response;
    }

    public function UpdateProfilesAction(Request $request)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $date = new \DateTime("now");
        $post = $request->getContent();

        $post = json_decode($post);

        $name = $post->name;
        $lastname = $post->lastname;
        $email = $post->email;
        $biographie = $post->biographie;
        $profile_id = $post->profile_id;
        $em = $this->getDoctrine()->getManager();
        $profiles = $em->getRepository('AppBundle:Profiles')->find($profile_id);
        $email_profiles = $em->getRepository('AppBundle:Profiles')->findOneBy(array('email' => $email));


        if (!$profiles) {
            $response = new Response($serializer->serialize(array('message' => 'false'), 'json'));
            return $response;
        }

        $profiles->setName($name);
        $profiles->setLastname($lastname);
        $profiles->setEmail($email);
        $profiles->setBiographie($biographie);
        $profiles->setUpdatedAt($date);
        $em->flush();


        $response = new Response($serializer->serialize(array('message' => 'true'), 'json'));
        return $response;
    }


    public function UpdatePhotosAction(Request $request)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $date = new \DateTime("now");
        $post = $request->getContent();

        $post = json_decode($post);

        $photo = $post->photo;
        $profile_id = $post->profile_id;
        $em = $this->getDoctrine()->getManager();
        $profiles = $em->getRepository('AppBundle:Profiles')->find($profile_id);
        if (!$profiles) {
            $response = new Response($serializer->serialize(array('message' => 'false'), 'json'));
            return $response;
        }

        $profiles->setPhoto($photo);
        $profiles->setUpdatedAt($date);
        $em->flush();
        $response = new Response($serializer->serialize(array('message' => 'true'), 'json'));
        return $response;
    }


    public function UpdateThemesAction(Request $request)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $date = new \DateTime("now");
        $post = $request->getContent();

        $post = json_decode($post);

        $theme = $post->theme;
        $profile_id = $post->profile_id;
        $em = $this->getDoctrine()->getManager();
        $profiles = $em->getRepository('AppBundle:Profiles')->find($profile_id);
        if (!$profiles) {
            $response = new Response($serializer->serialize(array('message' => 'false'), 'json'));
            return $response;
        }

        $profiles->setTheme($theme);
        $profiles->setUpdatedAt($date);
        $em->flush();
        $response = new Response($serializer->serialize(array('message' => 'true'), 'json'));
        return $response;
    }

    public function DeleteProfilesAction($profile_id)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $em = $this->getDoctrine()->getManager();
        $profile = $em->getRepository('AppBundle:Profiles')->find($profile_id);

        if (!$profile) {
            $response = new Response($serializer->serialize(array('message' => 'false'), 'json'));
            return $response;
        }

        $tasks = $em->getRepository('AppBundle:Tasks')->findBy(array('user_id' => $profile_id));

        foreach ($tasks as $value) {
            $value->setActive(0);
            $em->persist($value);
        }

        $profile->setActive(0);
        $em->flush();

        $response = new Response($serializer->serialize(array('message' => 'true'), 'json'));

        return $response;
    }

    public function AuthentificationProfilesAction(Request $request)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $post = $request->getContent();

        $post = json_decode($post);
        $password = $post->password;
        $email = $post->email;

        $em = $this->getDoctrine()->getManager();
        $profile = $em->getRepository('AppBundle:Profiles')->findOneBy(array('email' => $email, 'password' => md5($password), 'active' => 1));

        if (!$profile) {
            $response = new Response($serializer->serialize(array('message' => 'false'), 'json'));
            return $response;
        }

        $Id = $profile->getId();
        $response = new Response($serializer->serialize(array('message' => 'true', 'Id' => $Id), 'json'));
        return $response;
    }
}