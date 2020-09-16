<?php

use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    public function videoCreate()
    {
        $wikiSearchTerm = $this->ask('Type a Wikipedia search term: ');

        $options = ['who_is' => 'Who is', 'what_is' => 'What is', 'history_of' => 'History of'];
        $choiceQuestion = new ChoiceQuestion($this->formatQuestion("Choose a option for {$wikiSearchTerm}"), array_values($options));
        $wikiSearchPrefix = $this->doAsk($choiceQuestion);

        //Search on wikipedia
        $textRobot = new \VMaker\Robots\TextRobot();
        $wikiContent = $textRobot->fetchContentFromWikipedia($wikiSearchTerm);

        $wikiContent->content;
        $wikiContent->summary;


        $this->writeln($wikiContent->title);
    }
}
