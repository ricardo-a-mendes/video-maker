<?php

use Robo\Tasks;
use Symfony\Component\Console\Question\ChoiceQuestion;
use VMaker\Data\Content;
use VMaker\Data\Sentence;
use VMaker\Robots\TextRobot;
use VMaker\Robots\ImageRobot;

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends Tasks
{
    public function videoCreate()
    {
        $dataContent = new Content();
        $textRobot = new TextRobot();
        $imageRobot = new ImageRobot();

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
        $algorithmiaResponse = $textRobot->fetchContentFromWikipedia($wikiSearchTerm);
        $dataContent->setSourceContentOriginal($algorithmiaResponse->getContent());

        //Sanitizing wikipedia text
        $sanitized = $textRobot->sanitizeContent($dataContent->getSourceContentOriginal());
        $dataContent->setSourceContentSanitized($sanitized);

        $sentences = $textRobot->breakContentIntoSentences($dataContent->getSourceContentSanitized());
        foreach ($sentences as $i => $sentence) {
            $sentenceKeywords = $textRobot->fetchKeywords($sentence);

            $imageTerm = "{$dataContent->getSearchTerm()} {$sentenceKeywords->getKeywords()[0]->text}";
            $searchResponse = $imageRobot->searchImages($imageTerm);

            $images = [];

            /** @var Google_Service_Customsearch_Result $searchResult */
            foreach ($searchResponse->getItems() as $searchResult) {
                $images[] = [
                    'query' => $imageTerm,
                    'link' => $searchResult->getLink()
                ];
            }
            $s = (new Sentence())
                ->setText($sentence)
                ->setKeywords($sentenceKeywords->getKeywords())
                ->setImages($images);

            $dataContent->addSentence($s);

            if ($i == 3) {
                break;
            }
        }

        $this->writeln('Done');
    }

    public function videoSearch()
    {

    }
}
