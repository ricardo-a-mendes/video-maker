<?php

namespace VMaker\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class CreateVideoCommand extends Command
{
    /** @var string $defaultName */
    protected static $defaultName = 'app:create-video';

    /** @var QuestionHelper $questionHelper */
    private $questionHelper;

    /**
     * @inheritDoc
     */
    public function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->questionHelper = $this->getHelper('question');
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new video.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a video...');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @link https://symfony.com/doc/current/components/console/helpers/questionhelper.html
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $wikiSearchTerm = $this->askForSearchTerm($input, $output);
        $wikiSearchPrefix = $this->askForSearchPrefix($input, $output);

        $output->writeln($wikiSearchPrefix);

//        $choiceQuestion = new ChoiceQuestion('What do you want', ['eat', 'drink']);
//        $yourChoice = $question->ask($input, $output, $choiceQuestion);
//        $output->writeln($yourChoice);

        return Command::SUCCESS;
    }

    /**
     * Ask for the term to be searched on Wikipedia
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return string
     */
    private function askForSearchTerm(InputInterface $input, OutputInterface $output): string
    {
        $question = new Question('Type a Wikipedia search term: ');
        return $this->questionHelper->ask($input, $output, $question);
    }

    private function askForSearchPrefix(InputInterface $input, OutputInterface $output): string
    {
        $options = ['who_is' => 'Who is', 'what_is' => 'What is', 'history_of' => 'History of'];
        $choiceQuestion = new ChoiceQuestion('Choose one option', array_values($options));
        $yourChoice = $this->questionHelper->ask($input, $output, $choiceQuestion);

        return array_search($yourChoice, $options);
    }


}
