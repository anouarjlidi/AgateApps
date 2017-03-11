<?php

namespace UserBundle\Tests;

use Symfony\Component\DomCrawler\Form;
use Tests\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    const USER_NAME = 'test_user';
    const USER_NAME_AFTER_UPDATE = 'user_updated';

    public function testForbiddenAdmin()
    {
        $client = $this->getClient('back.esteren.dev', [], 'ROLE_USER');

        $client->request('GET', '/fr/');

        static::assertSame(403, $client->getResponse()->getStatusCode());
    }

    public function testAllowedAdmin()
    {
        $client = $this->getClient('back.esteren.dev', [], 'ROLE_ADMIN');

        $client->request('GET', '/fr/');

        static::assertSame(302, $client->getResponse()->getStatusCode());
        static::assertContains('/fr/?action=list&entity=Page', $client->getResponse()->headers->get('Location'));
        $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }

    /**
     * Test registration action
     */
    public function testRegister()
    {
        static::resetDatabase();

        $client = $this->getClient('www.esteren.dev');

        $crawler = $client->request('GET', '/fr/register/');

        /** @var Form $form */
        $form = $crawler->filter('form.fos_user_registration_register')->form();

        // Fill registration form
        $form['fos_user_registration_form[username]'] = static::USER_NAME;
        $form['fos_user_registration_form[email]'] = 'test@local.host.dev';
        $form['fos_user_registration_form[plainPassword][first]'] = 'fakePassword';
        $form['fos_user_registration_form[plainPassword][second]'] = 'fakePassword';

        // Submit form
        $crawler = $client->submit($form);

        // Check redirection was made correctly to the Profile page
        static::assertTrue($client->getResponse()->isRedirection(), 'Is not redirection');
        static::assertTrue($client->getResponse()->isRedirect('/fr/register/confirmed'), 'Does not redirect to profile');

        $crawler->clear();
        $crawler = $client->followRedirect();

        // Check flash messages are correct
        $flashUserCreated = $client->getKernel()->getContainer()->get('translator')->trans('registration.flash.user_created', [], 'FOSUserBundle');
        static::assertContains($flashUserCreated, $crawler->filter('#layout #flash-messages')->html());

        $crawler->clear();
    }

    /**
     * @depends testRegister
     */
    public function testChangePassword()
    {
        $client = $this->getClient('www.esteren.dev');
        $container = $client->getKernel()->getContainer();
        $user = $container->get('user.provider.username_or_email')->loadUserByUsername(static::USER_NAME);
        static::setToken($client, $user, $user->getRoles());

        $crawler = $client->request('GET', '/fr/profile/change-password');

        // Fill "change password" form
        $form = $crawler->filter('form.fos_user_change_password')->form();
        $form['fos_user_change_password_form[current_password]'] = 'fakePassword';
        $form['fos_user_change_password_form[plainPassword][first]'] = 'newPassword';
        $form['fos_user_change_password_form[plainPassword][second]'] = 'newPassword';

        $client->submit($form);

        // Check that it redirects to profile page
        static::assertSame(302, $client->getResponse()->getStatusCode());
        static::assertTrue($client->getResponse()->isRedirect('/fr/profile/'));

        $crawler->clear();
        $crawler = $client->followRedirect();

        $container = $client->getKernel()->getContainer();

        // Once redirected, we check the flash messages are correct
        $flashPasswordChanged = $container->get('translator')->trans('change_password.flash.success', [], 'FOSUserBundle');
        static::assertContains($flashPasswordChanged, $crawler->filter('#layout #flash-messages')->html());

        // Now check that new password is correctly saved in database
        $user = $container->get('user.provider.username_or_email')->loadUserByUsername(static::USER_NAME);
        $encoder = $container->get('security.encoder_factory')->getEncoder($user);
        static::assertTrue($encoder->isPasswordValid($user->getPassword(), 'newPassword', $user->getSalt()));

        $crawler->clear();
    }

    /**
     * @depends testChangePassword
     */
    public function testEditProfile()
    {
        $client = $this->getClient('www.esteren.dev');
        $container = $client->getKernel()->getContainer();
        $user = $container->get('user.provider.username_or_email')->loadUserByUsername(static::USER_NAME);
        static::setToken($client, $user, $user->getRoles());

        $crawler = $client->request('GET', '/fr/profile/edit');

        // Fill the "edit profile" form
        $form = $crawler->filter('form.fos_user_profile_edit')->form();
        $form['fos_user_profile_form[username]'] = static::USER_NAME_AFTER_UPDATE;
        $form['fos_user_profile_form[email]'] = $user->getEmail();
        $form['fos_user_profile_form[current_password]'] = 'newPassword';

        $client->submit($form);

        // Check that form submission redirects to same page
        static::assertSame(302, $client->getResponse()->getStatusCode());
        static::assertTrue($client->getResponse()->isRedirect('/fr/profile/'));
        $crawler->clear();
        $crawler = $client->followRedirect();

        // Once redirected, we check the flash messages are correct
        $flashPasswordChanged = $container->get('translator')->trans('profile.flash.updated', [], 'FOSUserBundle');
        static::assertContains($flashPasswordChanged, $crawler->filter('#layout #flash-messages')->html());

        $crawler->clear();
    }

    /**
     * @depends testEditProfile
     */
    public function testResetPasswordRequest()
    {
        $client = $this->getClient('www.esteren.dev');
        $container = $client->getKernel()->getContainer();
        $user = $container->get('user.provider.username_or_email')->loadUserByUsername(static::USER_NAME_AFTER_UPDATE);
        static::setToken($client, $user, $user->getRoles());

        $crawler = $client->request('GET', '/fr/resetting/request');

        $form = $crawler->filter('.fos_user_resetting_request')->form();

        $form['username'] = static::USER_NAME_AFTER_UPDATE;
        $client->submit($form);
        static::assertSame(302, $client->getResponse()->getStatusCode());
        $crawler->clear();
        $crawler = $client->followRedirect();

        // This message contains informations about user resetting token TTL.
        // This information is set in the FOSUser ResettingController and must be copied here just for testing.
        // We are testing in french.
        $emailSentMessage = 'Un e-mail a été envoyé. Il contient un lien sur lequel il vous faudra cliquer pour réinitialiser votre mot de passe.';

        static::assertContains($emailSentMessage, $crawler->filter('#content')->html());

        $tokenGenerator = $container->get('fos_user.util.token_generator');
        $user->setConfirmationToken($tokenGenerator->generateToken());

        $container->get('fos_user.user_manager')->updateUser($user, true);
        $crawler->clear();
        $crawler = $client->request('GET', '/fr/resetting/reset/'.$user->getConfirmationToken());

        $form = $crawler->filter('form.fos_user_resetting_reset')->form();

        $form['fos_user_resetting_form[plainPassword][first]'] = 'anotherNewPassword';
        $form['fos_user_resetting_form[plainPassword][second]'] = 'anotherNewPassword';

        $client->submit($form);

        static::assertSame(302, $client->getResponse()->getStatusCode());
        $crawler->clear();
        $crawler = $client->followRedirect();
        static::assertSame(1, $crawler->filter('.card-panel.success')->count());

        $crawler->clear();
    }
}
