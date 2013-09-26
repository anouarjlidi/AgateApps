<?php
namespace CorahnRin\ToolsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RepositoryCommand extends ContainerAwareCommand {

	private $base_file = <<<'BASE_FILE'
<?php
namespace {namespace};
use Doctrine\ORM\EntityRepository;

/**
 * {name}Repository
 *
 */
class {name}Repository extends EntityRepository {

}
BASE_FILE
;

	protected function configure() {

		//public function addArgument($name, $mode = null, $description = '', $default = null)
		$this
		->setName('corahnrin:generate:repositories')
		->setDescription('Generate entities repositories of a specific namespace.')
		->addArgument(
				'namespace',
				InputArgument::OPTIONAL,
				'Enter the namespace you want to scan (use "/" for compatibility).'
			)
		->addOption('no-backup', null, InputOption::VALUE_NONE, 'If defined, will not generate ".php~" backup files of existing entities and repositories.')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		//Récupération du service "dialog" pour les demandes à l'utilisateur
		$dialog = $this->getHelperSet()->get('dialog');

		//Dossiers de base et directory separator simplifié
		$DS = DIRECTORY_SEPARATOR;
		$global_dir = preg_replace('#(\\\|/)src(\\\|/)(.*)$#isUu', $DS, __DIR__);

		//Demande à l'utilisateur de récupérer le namespace
		$dir = $input->getArgument('namespace');
		if (!$dir) {
			$dir = $dialog->askAndValidate(
				$output,
				'Enter the namespace you want to scan (use "/" for compatibility) : '."\n > ",
				function ($answer) {
					$DS = DIRECTORY_SEPARATOR;
					$global_dir = preg_replace('#(\\\|/)src(\\\|/)(.*)$#isUu', $DS, __DIR__);
					$dir = trim($answer);
					$dir = trim($dir, '/\\');
					$dir = str_replace(array('/', '\\'), array('/', '/'), $dir);
					$dir = preg_replace('~/?Entity/?$~isUu', '', $dir);
					$dir = str_replace(array('/', '\\'), array($DS, $DS), $dir);
					$namespace = $dir;
					$dir = trim($dir, $DS);
					$scanned_dir = $global_dir.'src'.$DS.$dir.$DS.'Entity';
					if (!$dir) {
						throw new \RunTimeException('Please enter a correct namespace.');
					} elseif (!is_dir($scanned_dir)) {
						throw new \RunTimeException(
							'This namespace does not exist or is not located into the "'.'src'.$DS.'" folder.'.
							PHP_EOL.'Folder calculated : '.$scanned_dir
						);
					}
					return array('dir'=>$dir, 'namespace'=>$namespace);
				},
				false //nombre de tentatives
			);
		}

		//Retraitement des variables
		$namespace = $dir['namespace'];
		$dir = $dir['dir'];
		$namespace = trim($namespace);
		$namespace = trim($namespace, '/\\');
		$namespace = str_replace('/', '\\', $namespace);
		$namespace .= '\\Entity';
		$repo_dir = $global_dir.'src'.$DS.$dir.$DS.'Repository';
		$dir = $global_dir.'src'.$DS.$dir.$DS.'Entity';

		//Affichage des données récupérées
		$output->writeln(PHP_EOL.'Namespace : '.$namespace);
		$output->writeln('Scanning directory : '.$dir);

		//Scan des fichiers
		$files = scandir($dir);
		foreach ($files as $k => $v) {
			unset($files[$k]);
			if ($v !== '.' && $v !== '..' && preg_match('#\.php$#isUu', $v) && strpos($v, 'Repository') === false) {
				$valid_files[] = $v;
			}
		}
		$files = $valid_files;
		$files[''] = '> Skip this test';

		if (!count($files) || count($files) === 1) {
			throw new \RunTimeException('The folder is empty of any php file...');
		}

		//Affichage du contenu valide du dossier
		$selected = $dialog->select(
			$output,
			PHP_EOL.'If you want to ignore files you can specify them here. Separate the indexes with ",".'.PHP_EOL.'Folder contents :',
			$files,
			'0',
			false,
			'Entry "%s" does not exist',
			true // active l'option multiselect
		);

		$selected[] = '';

		foreach ($selected as $v) { unset($files[$v]); }

		//Affichage du contenu valide du dossier
		$output->writeln('Files scanned :');
		foreach ($files as $v) { $output->writeln(' > '.str_replace('.php', '', $v)); }

		//Confirmation d'exécution
		if (!$dialog->askConfirmation($output, 'Proceed ? [yes] ', 'yes')) {
			$output->writeln('Aborted...');
			return;
		}

		$output->writeln('The application will create a repository for each file in the following directory :');
		$output->writeln(' > '.$repo_dir);



		$files_count = 0;
		$files_overwritten = 0;
		$overwrite_all = 0;
		foreach ($files as $v) {
			$name = str_replace('.php', '', $v);
			$dest_file = $repo_dir.$DS.$name.'Repository.php';
			$overwrite = false;
			$exists = file_exists($dest_file);
			if ($exists) {
				if ($overwrite_all === 0) {
					$choices = array('yes','all','no','no-all','y','n','nall');
					$answer = $dialog->select(
						$output,
						'Following file already exists : '.PHP_EOL.'> '. str_replace($global_dir.$DS, '', $dest_file). PHP_EOL. 'Overwrite ?',
						$choices,
						'yes',
						false,
						'Answer "%s" is not correct'
					);

					$answer = $choices[$answer];
					$selected =	$answer === 'y' ? 'yes' :
								($answer === 'n' ? 'no' :
								($answer === 'nall' ? 'no-all' : $answer));
					if ($selected === 'yes') {
						$overwrite = true;
					} elseif ($selected === 'all') {
						$overwrite = true;
						$overwrite_all = 1;
					} elseif ($selected === 'no') {
						$overwrite = false;
					} elseif ($selected === 'no-all') {
						$overwrite = false;
						$overwrite_all = 2;
					}
				} elseif ($overwrite_all === 1) {
					$overwrite = true;
				} elseif ($overwrite_all === 2) {
					$overwrite = false;
				}
			} else {
				$overwrite = true;
			}
			$content = $this->base_file;
			$content = str_replace('{name}', $name, $content);
			$content = str_replace('{namespace}', $namespace, $content);
			if ($overwrite) {
				$files_count++;
				if ($exists) {
					$files_overwritten ++;
					$bu = $input->getOption('no-backup');
					if (!$bu) {
						file_put_contents($dest_file.'~', file_get_contents($dest_file));
					}
				}
				if (!is_dir($repo_dir)) { mkdir($repo_dir, 0777, true); }
				$output->writeln(($exists ? 'Overwriting' : 'Writing into'). ' file "'. $dest_file. '". '. file_put_contents($dest_file, $content). ' octets written.'. PHP_EOL);
			} else {
				$output->writeln('Skipping file "'. $dest_file. '"...'. PHP_EOL);
			}
		}//end foreach

		if ($dialog->askConfirmation(
			$output,
			'Add the parameter "ORM\\Entity(repositoryClass)" ? [y]es, [n]o : ',
			false)) {
			foreach ($files as $file) {
				$repositoryClass = str_replace('\\Entity', '', $namespace).'\\Repository\\'.str_replace('.php', '', $file).'Repository';
				$file = $dir.$DS.$file;
				$cnt = file_get_contents($file);
				$cnt = preg_replace('~@ORM.Entity(\([^\)]*\))?(\r)?\n~Uu', '@ORM\\Entity(repositoryClass="'.$repositoryClass.'")'."\n", $cnt);
				// echo substr($cnt, 0, 450), PHP_EOL, PHP_EOL, PHP_EOL;
				// $handle = fopen ("php://stdin","r");
				// $proceed = fgets($handle);
				// fclose($handle);
				$bu = $input->getOption('no-backup');
				if (!$bu) {
					file_put_contents($file.'~', file_get_contents($file));
				}
				file_put_contents($file, $cnt);
				echo 'Added parameter "repositoryClass" to file "', $file, '"', PHP_EOL;
			}
		}
	}
}