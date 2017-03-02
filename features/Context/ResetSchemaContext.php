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

use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Knp\FriendlyContexts\Dictionary\Taggable;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class ResetSchemaContext implements KernelAwareContext
{
    use Taggable;

    const RESET_SCHEMA_TAG = 'reset-database';

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
     * @BeforeScenario
     */
    public function beforeScenario(BeforeScenarioScope $event)
    {
        $this->storeTags($event);

        if ($this->hasTags([static::RESET_SCHEMA_TAG])) {
            if (defined('DATABASE_TEST_FILE') && defined('DATABASE_REFERENCE_FILE')) {
                if ($this->kernel && $this->kernel->getContainer()) {
                    $this->kernel->shutdown();
                }
                $fs = new Filesystem();
                $fs->copy(DATABASE_REFERENCE_FILE, DATABASE_TEST_FILE);
                if ($this->kernel) {
                    $this->kernel->boot();
                }
            } else {
                throw new \InvalidArgumentException('"DATABASE_TEST_FILE" and "DATABASE_REFERENCE_FILE" should be defined to reset database.');
            }
        }
    }
}
