<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
  public function index(): Response
  {
    return $this->render('user/index.html.twig', [
      'user' => $this->getUser(),
    ]);
  }

  public function new(
    Request $request,
    UserRepository $userRepository,
    UserPasswordHasherInterface $passwordHasher
  ): Response {

    if ($this->getUser() != null) {
      return $this->redirectToRoute('compteDetail');
  }

  $user = new User();

  $form = $this->createForm(UserType::class, $user);
  $form->handleRequest($request);

  $user->setRoles(array('ROLE_USER'));

  if ($form->isSubmitted() && $form->isValid()) {

      $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
      $user->setPassword($hashedPassword);

      $userRepository->save($user, true);

      dump($user);

      return $this->redirectToRoute('compteDetail', [], Response::HTTP_SEE_OTHER);
  }

  return $this->renderForm('compte/connexion.html.twig', [
      'user' => $user,
      'form' => $form,
  ]);
  }

  // #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
  // public function show(User $user): Response
  // {
  //     return $this->render('user/show.html.twig', [
  //         'user' => $user,
  //     ]);
  // }

  // #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
  // public function edit(Request $request, User $user, UserRepository $userRepository): Response
  // {
  //     $form = $this->createForm(UserType::class, $user);
  //     $form->handleRequest($request);

  //     if ($form->isSubmitted() && $form->isValid()) {
  //         $userRepository->save($user, true);

  //         return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
  //     }

  //     return $this->renderForm('user/edit.html.twig', [
  //         'user' => $user,
  //         'form' => $form,
  //     ]);
  // }

  // #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
  // public function delete(Request $request, User $user, UserRepository $userRepository): Response
  // {
  //     if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
  //         $userRepository->remove($user, true);
  //     }

  //     return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
  // }
}
