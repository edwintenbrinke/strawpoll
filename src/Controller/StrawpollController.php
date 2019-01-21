<?php


namespace App\Controller;


use App\Entity\Strawpoll;
use App\Entity\StrawpollOption;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class StrawpollController
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class StrawpollController extends AbstractController
{
    /**
     * @example {
        "name": "pizza",
        "options": [
            "salami",
            "hawaii"
        ]
     }
     * @Route("/api/strawpoll/create", name="create_strawpoll", methods={"POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Serializer\SerializerInterface $serializer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, SerializerInterface $serializer)
    {
        $post_data = $request->getContent();
        $data = json_decode($post_data, true);
        $em = $this->getDoctrine()->getManager();

        $strawpoll = new Strawpoll();
        $strawpoll->create($data);

        $em->persist($strawpoll);
        $em->flush();

        return new Response(
            $serializer->serialize(
                $strawpoll,
                'json',
                ['groups' => 'group']
            )
        );
    }

    /**
     * @Route("/api/strawpoll/view/{url_key}", name="view_strawpoll", methods={"GET"})
     * @param \App\Entity\Strawpoll $strawpoll
     * @param \Symfony\Component\Serializer\SerializerInterface $serializer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Strawpoll $strawpoll, SerializerInterface $serializer)
    {
        return new Response(
            $serializer->serialize(
                $strawpoll,
                'json',
                ['groups' => 'group']
            )
        );
    }

    /**
     * @Route("/api/strawpoll/vote/{id}", name="vote_strawpoll", methods={"POST"})
     * @param \App\Entity\StrawpollOption $strawpoll_option
     * @param \Symfony\Component\Serializer\SerializerInterface $serializer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function voteAction(StrawpollOption $strawpoll_option, SerializerInterface $serializer)
    {
        $strawpoll_option->vote();
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        //TODO: Set HTTP only cookie to limit voting

        return new Response(
            $serializer->serialize(
                $strawpoll_option->getStrawpoll(),
                'json',
                ['groups' => 'group']
            )
        );
    }

}