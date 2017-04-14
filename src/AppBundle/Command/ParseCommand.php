<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class ParseCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:parse')
            ->setDescription('Parse api.symfony.com')
            ->setHelp('This command allows you to create a user...')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $crawler = new Crawler();

        $html = file_get_contents('http://api.symfony.com/3.2/');
        $crawler->addHtmlContent($html);
        $crawler = $crawler->filter('div.namespaces > div.namespace-container > ul > li > a');

        $i=0;
        foreach ($crawler as $element){
            $url = $element->getAttribute('href');
//            $t_content = $element->textContent;
            //var_dump("http://api.symfony.com/3.2/".$url . " - " . $t_content);

            $crawler_classes = new Crawler();
            $html_classes = file_get_contents('http://api.symfony.com/3.2/'.$url);
            $crawler_classes->addHtmlContent($html_classes);
            $crawler_classes = $crawler_classes->filter('#page-content > div.namespace-list');

            foreach ($crawler_classes as $el){
                $get_url = $el->getAttribute('href');
                $t_content = $el->textContent;

                if ($i==1) var_dump($t_content);
                $i++; if ($i > 2) exit;
            }

        }







    }
}