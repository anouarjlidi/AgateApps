<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Security;

use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Security\UserProvider;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use UserBundle\Entity\User;

final class FormLoginAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    const USERNAME_OR_EMAIL_FORM_FIELD = '_username_or_email';
    const PASSWORD_FORM_FIELD = '_password';
    const SECURITY_REFERER_PARAMETER = '_security_referer';

    const PROVIDER_KEY = 'main'; // Firewall name

    const LOGIN_ROUTE = 'fos_user_security_login';

    const NO_REFERER_ROUTES = [
        self::LOGIN_ROUTE,
        'fos_user_security_check',
        'fos_user_security_register',
        'fos_user_security_logout',
        'fos_user_registration_register',
        'fos_user_registration_check_email',
        'fos_user_registration_confirm',
        'fos_user_registration_confirmed',
        'fos_user_resetting_request',
        'fos_user_resetting_send_email',
        'fos_user_resetting_check_email',
        'fos_user_resetting_reset',
        'fos_user_change_password',
    ];

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    /**
     * @var UserManager
     */
    private $userManager;

    public function __construct(UserManager $userManager, RouterInterface $router, UserPasswordEncoderInterface $encoder)
    {
        $this->router = $router;
        $this->encoder = $encoder;
        $this->userManager = $userManager;
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        if ($request->hasSession()) {
            if (in_array($request->attributes->get('_route'), static::NO_REFERER_ROUTES, true)) {
                $this->removeTargetPath($request->getSession(), static::PROVIDER_KEY);
            } else {
                $this->saveTargetPath($request->getSession(), static::PROVIDER_KEY, $request->getUri());
            }
        }

        return parent::start($request, $authException);
    }

    /**
     * {@inheritdoc}
     */
    protected function getLoginUrl()
    {
        return $this->router->generate(static::LOGIN_ROUTE);
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        if ($request->getPathInfo() !== $this->router->generate('fos_user_security_check')) {
            return null;
        }

        $usernameOrEmail = $request->request->get(self::USERNAME_OR_EMAIL_FORM_FIELD);
        $request->getSession()->set(Security::LAST_USERNAME, $usernameOrEmail);
        $password = $request->request->get(self::PASSWORD_FORM_FIELD);

        return new UsernamePasswordCredentials(
            $usernameOrEmail,
            $password
        );
    }

    /**
     * {@inheritdoc}
     *
     * @param UsernamePasswordCredentials $credentials
     * @param UserProvider                $userProvider
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials->getUsernameOrEmail());
    }

    /**
     * {@inheritdoc}
     *
     * @param UsernamePasswordCredentials $credentials
     * @param UserInterface|User          $user
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        if (!$this->encoder->isPasswordValid($user, $credentials->getPassword())) {
            throw new BadCredentialsException();
        }

        $user->setLastLogin(new \DateTime());
        $this->userManager->updateUser($user);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // if the user hit a secure page and start() was called, this was
        // the URL they were on, and probably where you want to redirect to
        if ($request->hasSession()) {
            $targetPath = $this->getTargetPath($request->getSession(), $providerKey) ?: $this->router->generate('root');
        } else {
            $targetPath = $this->router->generate('root');
        }

        return new RedirectResponse($targetPath);
    }
}
