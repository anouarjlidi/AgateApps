<?php

namespace Tests\User\Controller;

use Tests\WebTestCase;
use Symfony\Component\DomCrawler\Form;

class SecurityControllerTest extends WebTestCase
{

    public function testForceLogin()
    {
        $client = $this->getClient('www.esteren.dev', array(), 'ROLE_USER');

        $crawler = $client->request('GET', '/fr/profile/');

        if (403 === $client->getResponse()->getStatusCode()) {
            static::markTestSkipped('Skipped because still in restrictive mode.');
        }

        static::assertEquals(401, $client->getResponse()->getStatusCode());

        $form = $crawler->filter('#form_login');
        static::assertEquals(1, $form->count());
        static::assertContains('/login_check', $form->attr('action'));
    }

    public function testForbiddenAdmin()
    {
        $client = $this->getClient('back.esteren.dev', array(), 'ROLE_USER');

        $client->request('GET', '/fr/');

        static::assertEquals(403, $client->getResponse()->getStatusCode());
    }

    public function testAllowedAdmin()
    {
        $client = $this->getClient('back.esteren.dev', array(), 'ROLE_ADMIN');

        $client->request('GET', '/fr/');

        static::assertEquals(302, $client->getResponse()->getStatusCode());
        static::assertContains('/fr/?action=list&entity=Page', $client->getResponse()->headers->get('Location'));
        $client->followRedirect();
        static::assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAllProfileProcesses()
    {
        $client = $this->getClient('www.esteren.dev');

        $container = static::$kernel->getContainer();

        $crawler = $client->request('GET', '/fr/register/');

        /** @var Form $form */
        $form = $crawler->filter('form.fos_user_registration_register')->form();

        $form['fos_user_registration_form[username]'] = 'test_user';
        $form['fos_user_registration_form[email]'] = 'test@local.host.dev';
        $form['fos_user_registration_form[plainPassword][first]'] = 'fakePassword';
        $form['fos_user_registration_form[plainPassword][second]'] = 'fakePassword';

        $crawler = $client->submit($form);

        static::assertEquals(302, $client->getResponse()->getStatusCode(), $crawler->html());

        $crawler->clear();
        $crawler = $client->followRedirect();

        $msg1 = $container->get('translator')->trans('registration.confirmed', array('%username%'=>'test_user'), 'FOSUserBundle');
        $msg2 = $container->get('translator')->trans('registration.flash.user_created', array(), 'FOSUserBundle');

        static::assertContains($msg1, $crawler->filter('#layout #content p')->html());
        static::assertContains($msg2, $crawler->filter('#layout #flash-messages')->html());

        $crawler->clear();
        $crawler = $client->request('GET', '/fr/profile/change-password');

        /** @var Form $form */
        $form = $crawler->filter('form.fos_user_change_password')->form();

        $form['fos_user_change_password_form[current_password]'] = 'fakePassword';
        $form['fos_user_change_password_form[plainPassword][first]'] = 'newPassword';
        $form['fos_user_change_password_form[plainPassword][second]'] = 'newPassword';

        $client->submit($form);

        static::assertEquals(302, $client->getResponse()->getStatusCode());
        static::assertTrue($client->getResponse()->isRedirect('/fr/profile/'));

        $crawler->clear();
        $crawler = $client->followRedirect();

        $msg1 = $container->get('translator')->trans('change_password.flash.success', array('%username%'=>'test_user'), 'FOSUserBundle');
        $msg2 = $container->get('translator')->trans('form.username', array('%username%'=>'test_user'), 'FOSUserBundle');
        static::assertContains($msg1, $crawler->filter('#layout #flash-messages')->html());
        static::assertContains($msg2, $crawler->filter('#layout #content p')->html());

        $user = $container->get('fos_user.user_provider.username')->loadUserByUsername('test_user');
        $encoder = $container->get('security.encoder_factory')->getEncoder($user);
        static::assertTrue($encoder->isPasswordValid($user->getPassword(), 'newPassword', $user->getSalt()));

        $crawler->clear();
        $crawler = $client->request('GET', '/fr/profile/edit');

        /** @var Form $form */
        $form = $crawler->filter('form.fos_user_profile_edit')->form();

        $form['fos_user_profile_form[username]'] = 'user_updated';
        $form['fos_user_profile_form[email]'] = $user->getEmail();
        $form['fos_user_profile_form[current_password]'] = 'newPassword';

        $client->submit($form);
        static::assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler->clear();
        $crawler = $client->followRedirect();
        static::assertEquals(1, $crawler->filter('.alert.alert-success.success')->count());

        $crawler->clear();
        $crawler = $client->request('GET', '/fr/resetting/request');

        /** @var Form $form */
        $form = $crawler->filter('.fos_user_resetting_request')->form();

        $form['username'] = 'user_updated';
        $client->submit($form);
        static::assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler->clear();
        $crawler = $client->followRedirect();
        static::assertContains($container->get('translator')->trans('resetting.check_email', array('%email%' => '...@local.host.dev'), 'FOSUserBundle'), $crawler->filter('#content')->html());

        $tokenGenerator = $container->get('fos_user.util.token_generator');
        $user->setConfirmationToken($tokenGenerator->generateToken());

        $container->get('fos_user.user_manager')->updateUser($user, true);
        $crawler->clear();
        $crawler = $client->request('GET', '/fr/resetting/reset/'.$user->getConfirmationToken());

        /** @var Form $form */
        $form = $crawler->filter('form.fos_user_resetting_reset')->form();

        $form['fos_user_resetting_form[plainPassword][first]'] = 'anotherNewPassword';
        $form['fos_user_resetting_form[plainPassword][second]'] = 'anotherNewPassword';

        $client->submit($form);

        static::assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler->clear();
        $crawler = $client->followRedirect();
        static::assertEquals(1, $crawler->filter('.alert.alert-success.success')->count());
    }

}
