<?php

namespace App\AppBundle\Controller;

use App\IMBundle\Entity\Chat;
use App\IMBundle\Entity\Message;
use App\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/im/{user}", name="app_im")
     * @Template()
     */
    public function showAction(User $user)
    {
        $em = $this->getManager();

        foreach ($user->getChats() as $chat) {
            /** @var Chat $chat */
            echo $chat->getMessages()->count();
//            foreach ($chat->getMessages() as $message) {
//                echo $message->getId();
//            }

        }

        return ['user' => $user];
    }

    /**
     * @Route("/im/{user}/chat/{chat}", name="app_im_chat")
     * @Template()
     */
    public function chatAction(User $user, Chat $chat)
    {
        return ['user' => $user, 'chat' => $chat];
    }

    /**
     * @Route("/im/create", name="app_im_create")
     * @Template()
     */
    public function createAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $user1 = $em->getRepository('UserBundle:User')->findOneBy(['name' => 'Саша']);
        if (!$user1) {
            $user1 = new User();
            $user1->setName('Саша');
        }
        $user2 = $em->getRepository('UserBundle:User')->findOneBy(['name' => 'Паша']);
        if (!$user2) {
            $user2 = new User();
            $user2->setName('Паша');
        }
        $user3 = $em->getRepository('UserBundle:User')->findOneBy(['name' => 'Маша']);
        if (!$user3) {
            $user3 = new User();
            $user3->setName('Маша');
        }

        $em->createQuery('DELETE IMBundle:Message')->execute();
        $em->createQuery('DELETE IMBundle:Chat')->execute();

        $user1->getChats()->clear();
        $user2->getChats()->clear();

        $user1->getUnseens()->clear();
        $user2->getUnseens()->clear();

        $em->persist($user1);
        $em->persist($user2);
        $em->persist($user3);

        $em->flush();


        $chat1 = new Chat();

        $chat1->setAuthor($user1);
        $chat1->addUser($user1);
        $chat1->addUser($user2);

        $chat2 = new Chat();

        $chat2->setAuthor($user2);
        $chat2->addUser($user1);
        $chat2->addUser($user3);

        $message1 = new Message();
        $message1->setBody('От Саши Паше');
        $message1->setChat($chat1);
        $message1->setAuthor($user1);

        $user2->addUnseen($message1);

        $em->persist($message1);

        $message2 = new Message();
        $message2->setBody('От Паши Саше');
        $message2->setChat($chat1);
        $message2->setAuthor($user2);
        $now = new \DateTime();
        $message2->setCreated($now->modify('+2 minutes'));

        $user1->addUnseen($message2);

        $em->persist($message2);

        $em->persist($chat1);
        $em->persist($chat2);

        $em->flush();

        return [];
    }

    /**
     * @return EntityManager
     */
    private function getManager()
    {
        return $this->getDoctrine()->getManager();
    }
}
