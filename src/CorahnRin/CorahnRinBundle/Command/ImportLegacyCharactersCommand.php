<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\Command;

use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharWays;
use CorahnRin\CorahnRinBundle\Entity\Characters;
use CorahnRin\CorahnRinBundle\Entity\Games;
use CorahnRin\CorahnRinBundle\Entity\Ways;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use UserBundle\Entity\User;
use UserBundle\Repository\UserRepository;

class ImportLegacyCharactersCommand extends ContainerAwareCommand
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Connection
     */
    private $legacyCnx;

    /**
     * @var SymfonyStyle
     */
    private $io;

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var UserRepository
     */
    private $userManager;

    /**
     * @var User[]
     */
    private $users = [];

    /**
     * @var EntityRepository[]
     */
    private $repositories = [];

    /**
     * @var Games[]
     */
    private $games = [];

    /**
     * @var Ways[]
     */
    private $ways;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('corahnrin:legacy_import:characters')
            ->addOption('strategy-existing', 's', InputOption::VALUE_OPTIONAL, '')
            ->setDescription('Create characters from the old database and insert them here.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        // Defining specific properties for this class
        $this->input       = $input;
        $this->io          = new SymfonyStyle($input, $output);
        $this->userManager = $container->get(UserRepository::class);
        $doctrine          = $container->get('doctrine');
        $this->em          = $doctrine->getManager();
        $this->legacyCnx   = $doctrine->getConnection('legacy');

        $sql = <<<'SQL'

    SELECT

    c.char_id,
        c.char_name,
        c.char_job,
        c.char_origin,
        c.char_people,
        c.char_content,
        c.char_date_creation,
        c.char_date_update,
        c.char_status,
        c.char_confirm_invite,
        c.game_id,
        c.user_id,

        j.job_id,
        j.job_name,
        j.job_desc,
        j.job_book,

        r.region_id,
        r.region_name,
        r.region_desc,
        r.region_kingdom,

        g.game_summary,
        g.game_id,
        g.game_name,
        g.game_summary,
        g.game_notes,
        g.game_mj,

        u.user_id,
        u.user_name,
        u.user_password,
        u.user_email,
        u.user_acl,
        u.user_status,
        u.user_confirm,

        u_gm.user_id as gm_user_id,
        u_gm.user_name as gm_user_name,
        u_gm.user_password as gm_user_password,
        u_gm.user_email as gm_user_email,
        u_gm.user_acl as gm_user_acl,
        u_gm.user_status as gm_user_status,
        u_gm.user_confirm as gm_user_confirm

    FROM est_characters c

    LEFT JOIN est_jobs j ON c.char_job = j.job_id

    LEFT JOIN est_regions r ON c.char_origin = r.region_id

    LEFT JOIN est_games g ON c.game_id = g.game_id
        LEFT JOIN est_users u_gm ON u_gm.user_id = g.game_mj 

    LEFT JOIN est_users u ON c.user_id = u.user_id

SQL;

        $characters = $this->legacyCnx->query($sql)->fetchAll();

        foreach ($characters as $arrayCharacter) {
            $character     = new Characters();
            $jsonCharacter = json_decode($arrayCharacter['char_content'], true);

            $character
                ->setName($arrayCharacter['char_name'])
                ->setSex($arrayCharacter['sexe'] === 'Femme' ? Characters::FEMALE : Characters::MALE)
                ->setDescription($arrayCharacter['details']['description'])
                ->setOrientation($arrayCharacter['orientation']['name'])
                ->setAge($arrayCharacter['age'])
            ;

            $this
                ->processUser($character, $arrayCharacter)
                ->processGame($character, $arrayCharacter)
                ->processWays($character, $jsonCharacter)
                ->processJob($character, $jsonCharacter)
                ->processDomains($character, $jsonCharacter)
                ->processBirthplace($character, $jsonCharacter)
                ->processTraits($character, $jsonCharacter)
                ->processSetbacks($character, $jsonCharacter)
                ->processAdvantages($character, $jsonCharacter)
                ->processMentalData($character, $jsonCharacter)
            ;

            // FIXME
            throw new \RuntimeException('Fix me');
        }
    }

    /**
     * @param string|null $email
     * @param string|null $username
     *
     * @return User|null
     */
    private function getUser($email = null, $username = null)
    {
        $user = null;

        $userByUsername = $username ? $this->userManager->findOneBy(['username' => $username]) : null;
        $userByEmail    = $email ? $this->userManager->findOneBy(['email' => $email]) : null;

        if ($userByEmail && $userByUsername && $userByEmail->getId() !== $userByUsername->getId()) {
            if ($this->input->isInteractive()) {
                $whichUser = $this->io->choice(
                    'There are two different users with username & email:'.PHP_EOL.
                    $userByEmail->getId().' / '.$userByEmail->getUsername().' / '.$userByEmail->getEmail().PHP_EOL.
                    $userByUsername->getId().' / '.$userByUsername->getUsername().' / '.$userByUsername->getEmail(),
                    [$userByEmail->getId(), $userByUsername->getId()]
                );

                // FIXME
                throw new \RuntimeException('Fix me');
            }
            $this->io->warning([
                'Passed conflicting usernames:',
                $userByEmail->getId().' / '.$userByEmail->getUsername().' / '.$userByEmail->getEmail().PHP_EOL,
                $userByUsername->getId().' / '.$userByUsername->getUsername().' / '.$userByUsername->getEmail(),
            ]);
        } elseif ($userByEmail || $userByUsername) {
            $user = $userByEmail ?: $userByUsername;
        } else {
            $user = new User();

            $user
                ->setUsername($username)
                ->setEmail($email)
                ->setPlainPassword($this->getContainer()->get('user.util.token_generator')->generateToken())
            ;

            $this->em->persist($user);
        }

        return $user;
    }

    /**
     * @param string $repoName
     *
     * @return EntityRepository
     */
    private function getRepository($repoName)
    {
        if (array_key_exists($repoName, $this->repositories)) {
            return $this->repositories[$repoName];
        }

        return $this->repositories[$repoName] = $this->em->getRepository($repoName);
    }

    /**
     * @param Characters $character
     * @param array[]    $arrayCharacter
     *
     * @return $this
     */
    private function processUser(Characters $character, array $arrayCharacter)
    {
        $user            = null;
        $legacyUserEmail = $arrayCharacter['user_email'];

        if (array_key_exists($legacyUserEmail, $this->users)) {
            $user = $this->users[$legacyUserEmail];
        }

        if (null === $user && $arrayCharacter['user_id']) {
            $user = $this->getUser($arrayCharacter['user_email'], $arrayCharacter['user_name']);
        }

        if ($user) {
            $character->setUser($user);
            $this->users[$user->getEmail()] = $user;
        }

        return $this;
    }

    /**
     * @param Characters $character
     * @param array[]    $arrayCharacter
     *
     * @return $this
     */
    private function processGame(Characters $character, array $arrayCharacter)
    {
        $game         = null;
        $legacyGameId = $arrayCharacter['game_id'];

        if (array_key_exists($legacyGameId, $this->games)) {
            $game = $this->games[$legacyGameId];
        }

        if (null === $game && $arrayCharacter['game_id']) {
            $game = $this->getRepository('CorahnRinBundle:Games')->find($arrayCharacter['game_id']);

            if (!$game) {
                $game = new Games();

                $user = $this->getUser($arrayCharacter['gm_user_email'], $arrayCharacter['gm_user_name']);

                if (!$user) {
                    $this->io->warning('Passed insertion for game "'.$arrayCharacter['game_name'].'", because no user was found.');

                    return $this;
                }

                $game
                    ->setName($arrayCharacter['game_name'])
                    ->setGmNotes($arrayCharacter['game_notes'])
                    ->setSummary($arrayCharacter['game_summary'])
                    ->setGameMaster($user)
                ;

                $this->em->persist($game);
            }
        }

        if ($game) {
            $character->setGame($game);
        }

        return $this;
    }

    /**
     * @param Characters $character
     * @param array      $jsonCharacter
     *
     * @return $this
     */
    private function processWays(Characters $character, array $jsonCharacter)
    {
        $ways = $this->ways ?: ($this->ways = $this->getRepository('CorahnRinBundle:Ways')->findAll(true));

        foreach ($jsonCharacter['voies'] as $id => $voie) {
            if (array_key_exists($id, $ways)) {
                /** @var Ways $way */
                $way = $ways[$id];
            } else {
                throw new \RuntimeException('Cannot find way id "'.$id.'".');
            }

            $charWay = new CharWays();
            $charWay
                ->setWay($way)
                ->setCharacter($character)
                ->setScore($voie['val'])
            ;
        }

        return $this;
    }

    /**
     * @param Characters $character
     * @param array      $jsonCharacter
     *
     * @return $this
     */
    private function processJob(Characters $character, $jsonCharacter)
    {
        // TODO
        $this->io->block('To do '.__METHOD__, null, 'info');

        return $this;
    }

    /**
     * @param Characters $character
     * @param array      $jsonCharacter
     *
     * @return $this
     */
    private function processDomains(Characters $character, $jsonCharacter)
    {
        // TODO
        $this->io->block('To do '.__METHOD__, null, 'info');

        return $this;
    }

    /**
     * @param Characters $character
     * @param array      $jsonCharacter
     *
     * @return $this
     */
    private function processBirthplace(Characters $character, $jsonCharacter)
    {
        // TODO
        $this->io->block('To do '.__METHOD__, null, 'info');

        return $this;
    }

    /**
     * @param Characters $character
     * @param array      $jsonCharacter
     *
     * @return $this
     */
    private function processTraits(Characters $character, $jsonCharacter)
    {
        // TODO
        $this->io->block('To do '.__METHOD__, null, 'info');

        return $this;
    }

    /**
     * @param Characters $character
     * @param array      $jsonCharacter
     *
     * @return $this
     */
    private function processSetbacks(Characters $character, $jsonCharacter)
    {
        // TODO
        $this->io->block('To do '.__METHOD__, null, 'info');

        return $this;
    }

    /**
     * @param Characters $character
     * @param array      $jsonCharacter
     *
     * @return $this
     */
    private function processAdvantages(Characters $character, $jsonCharacter)
    {
        // TODO
        $this->io->block('To do '.__METHOD__, null, 'info');

        return $this;
    }

    /**
     * @param Characters $character
     * @param array      $jsonCharacter
     *
     * @return $this
     */
    private function processMentalData(Characters $character, $jsonCharacter)
    {
        // TODO
        $this->io->block('To do '.__METHOD__, null, 'info');

        return $this;
    }
}
