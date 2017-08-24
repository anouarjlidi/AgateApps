<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Tests\Security;

use Symfony\Component\DomCrawler\Form;
use Tests\WebTestCase;

abstract class AbstractSecurityControllerTest extends WebTestCase
{
    public const USER_NAME              = 'test_user';
    public const USER_NAME_AFTER_UPDATE = 'user_updated';

    abstract protected function getLocale(): string;

    public function testForbiddenAdmin()
    {
        $locale = $this->getLocale();

        $client = $this->getClient('back.esteren.dev', [], 'ROLE_USER');

        $client->request('GET', "/$locale/");

        static::assertSame(403, $client->getResponse()->getStatusCode());
    }

    public function testAllowedAdmin()
    {
        $locale = $this->getLocale();

        $client = $this->getClient('back.esteren.dev', [], 'ROLE_ADMIN');

        $client->request('GET', "/$locale/");

        static::assertSame(302, $client->getResponse()->getStatusCode());
        static::assertContains("/$locale/?action=list&entity=Page", $client->getResponse()->headers->get('Location'));
        $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testRegister()
    {
        $locale = $this->getLocale();

        static::resetDatabase();

        $client = $this->getClient('portal.esteren.dev');

        $crawler = $client->request('GET', "/$locale/register");

        $formNode = $crawler->filter('form.user_registration_register');

        static::assertEquals(1, $formNode->count(), 'Form wasn\'t found in the request');

        /** @var Form $form */
        $form = $formNode->form();

        // Fill registration form
        $form['registration_form[username]']      = static::USER_NAME.$locale;
        $form['registration_form[email]']         = "test-$locale@local.dev";
        $form['registration_form[plainPassword]'] = 'fakePassword';

        // Submit form
        $crawler  = $client->submit($form);
        $response = $client->getResponse();

        // Check redirection was made correctly to the Profile page
        static::assertTrue($response->isRedirect("/$locale/login"), "Does not redirect to login page.\n".$response->getContent());

        $crawler->clear();
        $crawler = $client->followRedirect();

        // Check flash messages are correct
        $flashUserCreated = $client->getKernel()->getContainer()->get('translator')->trans('registration.confirmed', ['%username%' => static::USER_NAME.$locale], 'UserBundle');
        static::assertContains($flashUserCreated, $crawler->filter('#layout #flash-messages')->html());

        $crawler->clear();
    }

    /**
     * @depends testRegister
     */
    public function testLogin()
    {
        $locale = $this->getLocale();

        $client = $this->getClient('portal.esteren.dev');

        $crawler = $client->request('GET', "/$locale/login");

        $formNode = $crawler->filter('form#form_login');

        static::assertEquals(1, $formNode->count(), 'Form wasn\'t found in the request');

        /** @var Form $form */
        $form = $formNode->form();

        // Fill registration form
        $form['_username_or_email'] = static::USER_NAME.$locale;
        $form['_password']          = 'fakePassword';

        // Submit form
        $crawler = $client->submit($form);

        $response = $client->getResponse();

        // Check redirection was made correctly to the Profile page
        static::assertTrue($response->isRedirect("/$locale"), 'Does not redirect to root page ("'.$response->headers->get('location').'" instead)');

        $crawler->clear();
        $client->followRedirects(true);
        $crawler = $client->followRedirect();

        // Check user is authenticated
        static::assertGreaterThanOrEqual(1, $crawler->filter('a.logout_link')->count());
        $logoutText = $client->getKernel()->getContainer()->get('translator')->trans('layout.logout', [], 'UserBundle');
        static::assertSame($logoutText, trim($crawler->filter('a.logout_link')->text()));

        $crawler->clear();
    }

    /**
     * @depends testLogin
     */
    public function testChangePassword()
    {
        $locale = $this->getLocale();

        $client    = $this->getClient('portal.esteren.dev');
        $container = $client->getKernel()->getContainer();
        $user      = $container->get('user.provider.username_or_email')->loadUserByUsername(static::USER_NAME.$locale);
        static::setToken($client, $user, $user->getRoles());

        $crawler = $client->request('GET', "/$locale/profile/change-password");

        // Fill "change password" form
        $form = $crawler->filter('form.user_change_password')->form();

        $form['change_password_form[current_password]']      = 'fakePassword';
        $form['change_password_form[plainPassword][first]']  = 'newPassword';
        $form['change_password_form[plainPassword][second]'] = 'newPassword';

        $client->submit($form);

        // Check that it redirects to profile page
        static::assertSame(302, $client->getResponse()->getStatusCode());
        static::assertTrue($client->getResponse()->isRedirect("/$locale/profile"));

        $crawler->clear();
        $crawler = $client->followRedirect();

        $container = $client->getKernel()->getContainer();

        // Once redirected, we check the flash messages are correct
        $flashPasswordChanged = $container->get('translator')->trans('change_password.flash.success', [], 'UserBundle');
        static::assertContains($flashPasswordChanged, $crawler->filter('#layout #flash-messages')->html());

        // Now check that new password is correctly saved in database
        $user    = $container->get('user.provider.username_or_email')->loadUserByUsername(static::USER_NAME.$locale);
        $encoder = $container->get('security.encoder_factory')->getEncoder($user);
        static::assertTrue($encoder->isPasswordValid($user->getPassword(), 'newPassword', $user->getSalt()));

        $crawler->clear();
    }

    /**
     * @depends testChangePassword
     */
    public function testEditProfile()
    {
        $locale = $this->getLocale();

        $client    = $this->getClient('portal.esteren.dev');
        $container = $client->getKernel()->getContainer();
        $user      = $container->get('user.provider.username_or_email')->loadUserByUsername(static::USER_NAME.$locale);
        static::setToken($client, $user, $user->getRoles());

        $crawler = $client->request('GET', "/$locale/profile");

        // Fill the "edit profile" form
        $form = $crawler->filter('form.user_profile_edit')->form();

        $form['profile_form[username]']        = static::USER_NAME_AFTER_UPDATE.$locale;
        $form['profile_form[email]']           = $user->getEmail();
        $form['profile_form[currentPassword]'] = 'newPassword';

        $client->submit($form);

        // Check that form submission redirects to same page
        static::assertSame(302, $client->getResponse()->getStatusCode());
        static::assertTrue($client->getResponse()->isRedirect("/$locale/profile#edit_profile"));
        $crawler->clear();
        $crawler = $client->followRedirect();

        // Once redirected, we check the flash messages are correct
        $flashPasswordChanged = $container->get('translator')->trans('profile.flash.updated', [], 'UserBundle');
        static::assertContains($flashPasswordChanged, $crawler->filter('#layout #flash-messages')->html());

        $crawler->clear();
    }

    /**
     * @depends testEditProfile
     */
    public function testResetPasswordRequest()
    {
        $locale = $this->getLocale();

        $client    = $this->getClient('portal.esteren.dev');
        $container = $client->getKernel()->getContainer();
        $user      = $container->get('user.provider.username_or_email')->loadUserByUsername(static::USER_NAME_AFTER_UPDATE.$locale);
        static::setToken($client, $user, $user->getRoles());

        $crawler = $client->request('GET', "/$locale/resetting/request");

        $form = $crawler->filter('form.user_resetting_request')->form();

        $form['username'] = static::USER_NAME_AFTER_UPDATE.$locale;
        $client->submit($form);
        static::assertSame(302, $client->getResponse()->getStatusCode());
        $crawler->clear();
        $crawler = $client->followRedirect();

        // This message contains informations about user resetting token TTL.
        // This information is set in the User ResettingController and must be copied here just for testing.
        $emailSentMessage = $client->getKernel()->getContainer()->get('translator')->trans('resetting.check_email', [], 'UserBundle');
        $emailSentMessage = nl2br($emailSentMessage, false);
        $emailSentMessage = trim($emailSentMessage);
        $emailSentMessage = preg_replace('~((\r)?\n)+~', '', $emailSentMessage);
        $crawlerContent   = trim($crawler->filter('#content')->html());
        $crawlerContent   = preg_replace('~((\r)?\n)+~', '', $crawlerContent);
        static::assertContains($emailSentMessage, $crawlerContent);

        $crawler->clear();
        $crawler = $client->request('GET', "/$locale/resetting/reset/".$user->getConfirmationToken());

        $form = $crawler->filter('form.user_resetting_reset')->form();

        $form['resetting_form[plainPassword]'] = 'anotherNewPassword';

        $client->submit($form);

        static::assertSame(302, $client->getResponse()->getStatusCode());
        $crawler->clear();
        $crawler = $client->followRedirect();
        static::assertSame(1, $crawler->filter('.card-panel.success')->count());

        $crawler->clear();
    }
}
