<?php

namespace Tests\User\Controller;

use Tests\WebTestCase;
use Symfony\Component\DomCrawler\Form;

class SecurityControllerTest extends WebTestCase
{

    public function testForceLogin()
    {
        $client = static::getClient('www.esteren.dev', array(), 'ROLE_USER');

        $crawler = $client->request('GET', '/fr/profile/');

        if (403 === $client->getResponse()->getStatusCode()) {
            $this->markTestSkipped('Skipped because still in restrictive mode.');
        }

        $this->assertEquals(401, $client->getResponse()->getStatusCode());

        $form = $crawler->filter('#form_login');
        $this->assertEquals(1, $form->count());
        $this->assertContains('/login_check', $form->attr('action'));
    }

    public function testForbiddenAdmin()
    {
        $client = static::getClient('back.esteren.dev', array(), 'ROLE_USER');

        $client->request('GET', '/fr/');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    public function testAllowedAdmin()
    {
        $client = static::getClient('back.esteren.dev', array(), 'ROLE_ADMIN');

        $client->request('GET', '/fr/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertContains('/fr/?action=list&entity=Page', $client->getResponse()->headers->get('Location'));
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAllProfileProcesses()
    {
        $client = static::getClient('www.esteren.dev');

        $container = static::$kernel->getContainer();

        $crawler = $client->request('GET', '/fr/register/');

        /** @var Form $form */
        $form = $crawler->filter('form.fos_user_registration_register')->form();

        $form['fos_user_registration_form[username]'] = 'test_user';
        $form['fos_user_registration_form[email]'] = 'test@local.host.dev';
        $form['fos_user_registration_form[plainPassword][first]'] = 'fakePassword';
        $form['fos_user_registration_form[plainPassword][second]'] = 'fakePassword';

        $crawler = $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode(), $crawler->html());

        $crawler->clear();
        $crawler = $client->followRedirect();

        $msg1 = $container->get('translator')->trans('registration.confirmed', array('%username%'=>'test_user'), 'FOSUserBundle');
        $msg2 = $container->get('translator')->trans('registration.flash.user_created', array(), 'FOSUserBundle');

        $content = $crawler->html();
        $this->assertContains($msg1, $content);
        $this->assertContains($msg2, $content);

        $crawler->clear();
        $crawler = $client->request('GET', '/fr/profile/change-password');

        /** @var Form $form */
        $form = $crawler->filter('form.fos_user_change_password')->form();

        $form['fos_user_change_password_form[current_password]'] = 'fakePassword';
        $form['fos_user_change_password_form[new][first]'] = 'newPassword';
        $form['fos_user_change_password_form[new][second]'] = 'newPassword';

        $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $crawler->clear();
        $crawler = $client->followRedirect();

        $msg = $container->get('translator')->trans('change_password.flash.success', array('%username%'=>'test_user'), 'FOSUserBundle');
        $content = $crawler->html();
        $this->assertContains($msg, $content);

        $user = $container->get('fos_user.user_manager')->loadUserByUsername('test_user');
        $encoder = $container->get('security.encoder_factory')->getEncoder($user);
        $this->assertTrue($encoder->isPasswordValid($user->getPassword(), 'newPassword', $user->getSalt()));

        $crawler->clear();
        $crawler = $client->request('GET', '/fr/profile/edit');

        /** @var Form $form */
        $form = $crawler->filter('form.fos_user_profile_edit')->form();

        $form['fos_user_profile_form[username]'] = 'user_updated';
        $form['fos_user_profile_form[email]'] = $user->getEmail();
        $form['fos_user_profile_form[current_password]'] = 'newPassword';

        $client->submit($form);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler->clear();
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('.fos_user_success')->count());

        $crawler->clear();
        $crawler = $client->request('GET', '/fr/resetting/request');

        /** @var Form $form */
        $form = $crawler->filter('.fos_user_resetting_request')->form();

        $form['username'] = 'user_updated';
        $client->submit($form);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $email = $client->getRequest()->getSession()->get('fos_user_send_resetting_email/email');
        $crawler->clear();
        $crawler = $client->followRedirect();
        $this->assertContains($container->get('translator')->trans('resetting.check_email', array('%email%' => $email), 'FOSUserBundle'), $crawler->filter('#content')->html());

        $tokenGenerator = $container->get('fos_user.util.token_generator');
        $user->setConfirmationToken($tokenGenerator->generateToken());

        $container->get('fos_user.user_manager')->updateUser($user, true);
        $crawler->clear();
        $crawler = $client->request('GET', '/fr/resetting/reset/'.$user->getConfirmationToken());

        /** @var Form $form */
        $form = $crawler->filter('form.fos_user_resetting_reset')->form();

        $form['fos_user_resetting_form[new][first]'] = 'anotherNewPassword';
        $form['fos_user_resetting_form[new][second]'] = 'anotherNewPassword';

        $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler->clear();
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('.fos_user_success')->count());
    }

}
