<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class UserContext implements Context, KernelAwareContext
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * Sets Kernel instance.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given /^a user:$/
     */
    public function theFollowingsUser(TableNode $table)
    {
        $rows = $table->getRows();
        $headers = array_shift($rows);

        $sortedHeaders = $headers;
        sort($sortedHeaders);
        if ($sortedHeaders !== ['email', 'password', 'username']) {
            dump($sortedHeaders);
            throw new \InvalidArgumentException('Users can only have email, username and password fields');
        }

        /** @var ContainerInterface $container */
        $container = $this->kernel->getContainer();

        $userManager = $container->get('fos_user.user_manager');

        foreach ($rows as $row) {
            $values = array_combine($headers, $row);
            $user = $userManager->createUser();

            $user
                ->setUsername($values['username'])
                ->setEmail($values['email'])
                ->setPlainPassword($values['password'])
                ->setEnabled(true)
            ;

            $userManager->updateUser($user, true);
        }
    }
}
