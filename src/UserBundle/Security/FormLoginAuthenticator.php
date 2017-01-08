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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
    protected function getLoginUrl()
    {
        return $this->router->generate('fos_user_security_login');
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

        $referer = $request->headers->get('referer');

        if ($referer && !preg_match('~login|register|check~iUu', $referer)) {
            $request->getSession()->set(self::SECURITY_REFERER_PARAMETER, $referer);
        } else {
            $request->getSession()->set(self::SECURITY_REFERER_PARAMETER, null);
        }

        return new UsernamePasswordCredentials(
            $usernameOrEmail,
            $password
        );
    }

    /**
     * {@inheritdoc}
     *
     * @param UsernamePasswordCredentials $credentials
     * @param UserProvider $userProvider
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials->getUsernameOrEmail());
    }

    /**
     * {@inheritdoc}
     *
     * @param UsernamePasswordCredentials $credentials
     * @param UserInterface|User $user
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
        $session = $request->getSession();

        // if the user hit a secure page and start() was called, this was
        // the URL they were on, and probably where you want to redirect to
        if ($session instanceof SessionInterface) {
            $targetPath = $session->get(self::SECURITY_REFERER_PARAMETER)
                ? : $session->get('_security.' . $providerKey . '.target_path');
        } else {
            $targetPath = $this->router->generate('root');
        }

        return new RedirectResponse($targetPath);
    }

}
