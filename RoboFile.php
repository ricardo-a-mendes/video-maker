<?php

use Robo\Tasks;
use Symfony\Component\Console\Question\ChoiceQuestion;
use VMaker\Data\Content;
use VMaker\Data\Sentence;
use VMaker\Robots\TextRobot;
use VMaker\Robots\ImageRobot;
use VMaker\Robots\VideoRobot;

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
        $videoRobot = new VideoRobot();

        //Requesting the term to be searched
        $wikiSearchTerm = 'will smith'; //$this->ask('Type a Wikipedia search term: ');
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
        $this->say("Fetching content from Wikipedia: {$wikiSearchTerm}");
        $algorithmiaResponse = $textRobot->fetchContentFromWikipedia($wikiSearchTerm);
        $dataContent->setSourceContentOriginal($algorithmiaResponse->getContent());

        //Sanitizing wikipedia text
        $this->say("Sanitizing content");
        $sanitized = $textRobot->sanitizeContent($dataContent->getSourceContentOriginal());
        $dataContent->setSourceContentSanitized($sanitized);

        $this->say("Splitting into sentences");
        $sentences = $textRobot->breakContentIntoSentences($dataContent->getSourceContentSanitized());

        $this->say("Working on sentences...");
        $totalSentences = count($sentences);
        foreach ($sentences as $i => $sentence) {
            $this->say(($i+1) . " out of {$totalSentences}");

            $this->writeln(" ├➜ Fetching keywords");
            $sentenceKeywords = $textRobot->fetchKeywords($sentence);

            $imageTerm = "{$dataContent->getSearchTerm()} {$sentenceKeywords->getKeywords()[0]->text}";
            $this->writeln(" ├➜ Searching images for '{$imageTerm}'");
            $searchResponse = $imageRobot->searchImages($imageTerm);

            $images = [];
            $downloadedImages = [];

            /** @var Google_Service_Customsearch_Result $searchResult */
            foreach ($searchResponse->getItems() as $searchResult) {
                $linkURL = $searchResult->getLink();
                if (in_array($linkURL, $downloadedImages)) {
                    $this->say("{$linkURL} already exists");
                    continue;
                }

                if (substr($linkURL, -4) != '.jpg' && substr($linkURL, -5) != '.jpeg') {
                    $this->say("Skipping '{$linkURL}' [not a valid type]");
                    continue;
                }

                $this->writeln(" ├➜ Downloading from {$linkURL}");
                $imagePath = $imageRobot->downloadImage($linkURL);
                if (is_null($imagePath)) {
                    continue;
                }

                $this->writeln(" ├➜ Resizing '{$imagePath}'");
                $resizedImagePath = $videoRobot->resize($imagePath);

                $images[] = [
                    'query' => $imageTerm,
                    'link' => $linkURL,
                    'saved_path' => $imagePath,
                    'resized_path' => $resizedImagePath
                ];

                $this->writeln('------------------------------------');
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

        $serialized = serialize($dataContent);
        file_put_contents('/application/src/Data/serialized.txt', $serialized);

        $this->writeln('Done');
    }

    public function videoSearch()
    {

        $v = new VideoRobot();
        $v->resize("/application/images/Amb-White-House.jpg");
    }
}
