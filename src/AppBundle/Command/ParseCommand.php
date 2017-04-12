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
            // the name of the command (the part after "bin/console")
            ->setName('app:parse')
            // the short description shown while running "php bin/console list"
            ->setDescription('Parse api.symfony.com')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $html = file_get_contents('http://api.symfony.com/3.2/');
        $crawler = new Crawler($html);

        $crawler1 = $crawler->filter('body#index > div#content > div#right-column > div#page-content > div.namespaces > div.namespace-container > ul > li > a');

        //namespace
        foreach ($crawler1 as $element){
            $url = $element->getAttribute('href');
            //var_dump($url);
        }


        $crawler2 = $crawler->filter('body#index > div#content > div#right-column > div#page-content > div.container-fluid.underlined > div.row > div.col-md-6 > em >  a');

        //interface
        foreach ($crawler2 as $element){

            $url = $element->getAttribute('href');
            var_dump($url);
        }


    }
}