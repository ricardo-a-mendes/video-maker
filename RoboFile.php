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
        $dataContent = new \VMaker\Data\Content();

        //Requesting the term to be searched
        $wikiSearchTerm = $this->ask('Type a Wikipedia search term: ');
        $dataContent->setSearchTerm($wikiSearchTerm);

        //Requesting the prefix
        $options = ['who_is' => 'Who is', 'what_is' => 'What is', 'history_of' => 'History of'];
        $choiceQuestion = new ChoiceQuestion(
            $this->formatQuestion("Choose a option for {$wikiSearchTerm}"),
            array_values($options)
        );
        $wikiSearchPrefix = $this->doAsk($choiceQuestion);
        $dataContent->setPrefix($wikiSearchPrefix);

        //Search on wikipedia
        $textRobot = new \VMaker\Robots\TextRobot();
        $algorithmiaResponse = $textRobot->fetchContentFromWikipedia($wikiSearchTerm);
        $dataContent->setSourceContentOriginal($algorithmiaResponse->getContent());

        $this->writeln($algorithmiaResponse->getTitle());
    }
}
