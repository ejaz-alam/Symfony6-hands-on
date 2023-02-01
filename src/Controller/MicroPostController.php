<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_posts')]
    public function index(MicroPostRepository $microPostRepository): Response
    {
//        $microPost = new MicroPost();
//        $microPost->setText('Hello Google!');
//        $microPost->setTitle('Hey, Its Symfony6.');
//        $microPost->setCreated(new \DateTime());
//        $microPostRepository->save($microPost, true);

//        $microPost = $microPostRepository->find(6);
//        $microPost->setTitle('Hey Ejaz, Its being updated.');
//        $microPostRepository->save($microPost, true);
//        dd('ok');
        return $this->render('micro_post/index.html.twig', [
            'posts' => $microPostRepository->findAll(),
        ]);
    }

    #[Route('/micro-post/{post}', name: 'app_micro_post')]
    public function showOne(MicroPost $post): Response
    {
        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)]
    public function addPost(Request $request, MicroPostRepository $microPostRepository): Response
    {
        $post = new MicroPost();
        $form = $this->createFormBuilder($post)
            ->add('text')
            ->add('title')
            ->add('submit', SubmitType::class, ['label' => 'Save'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setCreated(new \DateTime());
            $microPostRepository->save($post, true);
//            dd($form)0
            $this->addFlash('success', 'Your post has been added.');
           return $this->redirectToRoute('app_micro_posts');
        }

        return $this->render('micro_post/add.html.twig', [
            'form' => $form,
        ]);
    }
}
