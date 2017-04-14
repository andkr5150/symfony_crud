<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
use AppBundle\Entity\ClassSymfony;
use AppBundle\Entity\InterfaceSymfony;
use AppBundle\Entity\NamespaceSymfony;

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
        $html = file_get_contents('http://api.symfony.com/3.2/');
        $crawler = new Crawler($html);
        $crawler = $crawler->filter('div.namespaces > div.namespace-container > ul > li > a');

        foreach ($crawler as $element){
            $url = 'http://api.symfony.com/3.2/'.$element->getAttribute('href');
            var_dump('namespace - '.$url);

            $html_class = file_get_contents($url);
            $craw_class = new Crawler($html_class);

            //class
            foreach ($craw_class->filter('div.col-md-6 > a') as $item){
                var_dump('class - http://api.symfony.com/3.2/'. str_replace('\\', '/', $element->nodeValue).'/'.$item->nodeValue.'.html');
            }

            //interface
            foreach ($craw_class->filter('div.col-md-6 > em > a') as $item){
                var_dump('interface - http://api.symfony.com/3.2/'. str_replace('\\', '/', $element->nodeValue).'/'.$item->nodeValue.'.html');
            }
        }
    }
}