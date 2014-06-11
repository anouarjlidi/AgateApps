<?php
namespace Pierstoval\Bundle\ToolsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FilesCombineCommand extends ContainerAwareCommand {

	protected function configure() {

		$this
		->setName('pierstoval:combine:files')
		->setDescription('Combine multiple files.')
        ->setHelp('This command is used to generate a single file from multiple files, like LESS files..'."\n"
            .'Name the [output] file within its folder if you need'."\n"
            ."\n".'The command will generate a file combining all required files if they exist,'
            ."\n".'in the order you mention.'
            ."\n".''
            ."\n".'This is really useful when you want to combine LESS files into one file, for LessPHP to work better with Symfony2'
            ."\n".''
            ."\n".'You can specify the --replace option to overwrite any existing output file.'
            ."\n".'If you use the --append option, all mixed contents are appended to the file instead of replacing it.'
            )
        ->addArgument('output', InputArgument::OPTIONAL, 'Enter the output file name')
		->addArgument('files', InputArgument::IS_ARRAY, 'Enter the files you want to combine')
        ->addOption('replace', 'r', InputOption::VALUE_NONE, 'Replaces the output file if it already exists')
        ->addOption('append', 'a', InputOption::VALUE_NONE, 'Appends the contents to the file instead of replaceing it')
        ->addOption('no-prompt', null, InputOption::VALUE_NONE, 'Do not interact with user')
        ;
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		//Récupération du service "dialog" pour les demandes à l'utilisateur
		$dialog = $this->getHelperSet()->get('dialog');

		$output->writeln('Welcome to Pierstoval\'s Files Combinator !');
		$output->writeln('With this command, you will be able to compile all files you want into one file !');
		$output->writeln('This is really useful when you want to combine LESS files into one file, for LessPHP to work better with Symfony2');
		$output->writeln('');

		//Dossiers de base et directory separator simplifié
		$DS = DIRECTORY_SEPARATOR;
		$root = preg_replace('#(\\\|/)(src|vendor)(\\\|/)(.*)$#isUu', $DS, __DIR__);

        // Récupération des arguments
        $files = $input->getArgument('files');
        $outputFile = $input->getArgument('output');
        $replace = $input->getOption('replace');
        $append = $input->getOption('append');
        $interact = $input->getOption('no-prompt');

        // Au départ, le script n'est pas exécuté
        $proceed = false;
        $addedFiles = false;// Indique si on a ajouté des fichiers ou non

        if ($files) {
            $output->writeln('Files list :');
            foreach ($files as $k => $file) {
                if (file_exists(ROOT.DS.$file)) {
                    $output->writeln(' > '.$file);
                } else {
                    $output->writeln('File does not exist, removed > '.$file);
                    unset($files[$k]);
                }
            }
            $output->writeln('');
            if (!$interact) {
                if (!$dialog->askConfirmation($output, 'Add more files to the list ? (y/n) [yes] ', true)) {
                    $proceed = true;
                } else {
                    do {
                        $additionalFile = $dialog->askAndValidate(
                            $output,
                            'Enter an additional file (press Enter to finish) > ',
                            function ($f) {
                                $f = trim($f);
                                if ((file_exists(ROOT.DS.$f) && is_file(ROOT.DS.$f)) || !$f) { return $f; }
                                else {
                                    if (is_dir(ROOT.DS.$f)) {
                                        throw new \RunTimeException('You must enter a file name, not a directory.');
                                    } else {
                                        throw new \RunTimeException('This file does not exist.');
                                    }
                                }
                            });
                        if ($additionalFile) {
                            $addedFiles = true;
                            $files[] = $additionalFile;
                        }
                    } while (!!$additionalFile);
                }
            } else {
                $proceed = true;
            }
        } elseif (!$file && !$interact) {
            do {
                $additionalFile = $dialog->askAndValidate(
                    $output,
                    'Enter a file (press Enter to finish) > ',
                    function ($f) {
                        $f = trim($f);
                        if ((file_exists(ROOT.DS.$f) && is_file(ROOT.DS.$f)) || !$f) { return $f; }
                        else {
                            if (is_dir(ROOT.DS.$f)) {
                                throw new \RunTimeException('You must enter a file name, not a directory.');
                            } else {
                                throw new \RunTimeException('This file does not exist.');
                            }
                        }
                    });
                if ($additionalFile) {
                    $addedFiles = true;
                    $files[] = $additionalFile;
                }
            } while (!!$additionalFile);
        } else {
            throw new \RunTimeException('You must specify at least one existing file to combine.');
            exit;
        }
        if ($addedFiles) {
            $output->writeln("\n".'Files list :');
            foreach ($files as $file) {
                $output->writeln(' > '.$file);
            }
            $output->writeln('');
            if (!$interact) {
                if ($dialog->askConfirmation($output, 'Proceed ? (y/n) [yes] ', true)) {
                    $proceed = true;
                }
            } else {
                $proceed = true;
            }
        }

        if ($proceed) {
            if ($files) {
                $content = '';
                foreach ($files as $file) {
                    $output->writeln('Reading file : '.$file);
                    $cnt = file_get_contents(ROOT.DS.$file);
                    $content .= $cnt;
                    if (!$cnt) {
                        $output->writeln(' >> Empty file, or error occured. Check your file.');
                    }
                }

                if (!$content) {
                    if (!$interact) {
                        $proceed = $dialog->askConfirmation($output, 'No content has been retrieved from files combination, still create output file ? (y/n) [yes] ', true);
                    } else {
                        $proceed = true;
                    }
                }

                if ($proceed) {
                    if (!$outputFile) {
                        if (!$interact) {
                            $outputFile = $dialog->askAndValidate(
                                $output,
                                'Enter a name for the output file (press Enter to finish) > ',
                                function ($f) { return trim($f); }
                            );
                        } else {
                            throw new \RunTimeException('You must specify an output file name.');
                            exit;
                        }
                    }
                    if (!$replace) {
                        if (file_exists(ROOT.DS.$outputFile)) {
                            if (!$interact) {
                                $replace = $dialog->askConfirmation($output, "\n".'Following file already exists :'."\n".$outputFile."\n".'Overwrite ? (y/n) [yes] ', true);
                            } else {
                                $replace = true;
                            }
                        } else {
                            $replace = true;
                        }
                    }
                    if ($replace) {
                        if (!is_dir(dirname(ROOT.DS.$outputFile))) {
                            mkdir(dirname(ROOT.DS.$outputFile), 0777, true);
                        }
                        $add = "/*\n * Generated with Corahn-Rin Files Combinator".
                            "\n * Files list :";
                        foreach ($files as $file) {
                            $add .= "\n".' * '.$file;
                        }
                        $add .= "\n */\n";
                        $content = $add.$content;

                        if ($content === file_get_contents(ROOT.DS.$outputFile)) {
                            $output->writeln("\n".'No modification has been made, files are identical.');
                        } else {
                            $written = file_put_contents(ROOT.DS.$outputFile, $content, $append ? FILE_APPEND : 0);
                            if ($written) {
                                $output->writeln("\n".'Files combined !');
                                $output->writeln("\n".$written.' octets written in '.$outputFile);
                            } else {
                                throw new \RunTimeException('An error occured while writing combined files into the output file.'."\n".'This errors can sometime occurs because of file permissions or if nothing has been written in the file.');
                            }
                        }
                    }
                }
            } else {
                $output->writeln("\n".'No file to combine !');
            }
        } elseif (!$files) {
            $output->writeln("\n".'No file to combine !');
        }

		$output->writeln("\n".'End of function !');
		$output->writeln('Thanks for using CorahnRinTools, and see you soon !');

	}
}