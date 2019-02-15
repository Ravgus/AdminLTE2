<?php
/**
 * Created by PhpStorm.
 * User: ravgus
 * Date: 13.02.19
 * Time: 15:41
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/profile")
 * @IsGranted("ROLE_USER")
 */
class UserProfileController extends AbstractController
{
    /**
     * @Route("/", name="user_profile_index")
     */
    public function index()
    {
        return $this->render('profile/index.html.twig');
    }

    /**
     * @Route("/edit", name="user_profile_edit")
     * @param Request $request
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(
        Request $request,
        UserPasswordEncoderInterface $userPasswordEncoder,
        FileUploader $fileUploader)
    {
        /** @var User $user */
        $user = $this->getUser(); //get current log in user
        $logo = $user->getLogo();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $userPasswordEncoder->encodePassword($user, $user->getPlainPassword()); //encode password
            $user->setPassword($password);

            $file = $user->getLogo();

            if ($file instanceof UploadedFile) { //if image is downloaded by user
                $fileName = $fileUploader->upload($file, FileUploader::PATHS['USER']);
                $user->setLogo($fileName);
            } else {
                $user->setLogo($logo); //live previous image
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_profile_index');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
            'title' => 'Edit'
        ]);
    }
}