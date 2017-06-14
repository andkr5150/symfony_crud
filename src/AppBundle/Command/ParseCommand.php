<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
use AppBundle\Entity\ClassSymfony;
use AppBundle\Entity\InterfaceSymfony;
use AppBundle\Entity\NamespaceSymfony;


class ParseCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:parse')
            ->setDescription('Parse api.symfony.com')
            ->setHelp('This command allows you to create a user...')
            ->addOption(
                'pages',
                null,
                InputOption::VALUE_OPTIONAL,
                'How many pages you want to parse?',
                1000000
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $html = file_get_contents('http://api.symfony.com/3.2/Symfony.html');
        $crawler = new Crawler($html);
        $crawler = $crawler->filter('div.namespace-list > a');

        //var_dump( ' namespace count = ' . count($crawler));
        $this->addRecursion('http://api.symfony.com/3.2/Symfony.html', null);
/*
        foreach ($crawler as $element){
            $url = 'http://api.symfony.com/3.2/'.$element->getAttribute('href');
            $namespace = new NamespaceSymfony();
            $namespace->setName($element->textContent);
            $namespace->setUrl($url);
            $em->persist($namespace);


            $html_class = file_get_contents($url);
            $craw_class = new Crawler($html_class);

            //class
            foreach ($craw_class->filter('div.col-md-6 > a') as $item){
                $class = new ClassSymfony();
                $class->setName($item->textContent);
                $class->setUrl('http://api.symfony.com/3.2/'. str_replace('\\', '/', $element->nodeValue).'/'.$item->nodeValue.'.html');
                $class->setNamespace($namespace);
                $em->persist($class);
            }

            //interface
            foreach ($craw_class->filter('div.col-md-6 > em > a') as $item){
                $interface = new InterfaceSymfony();
                $interface->setName($item->textContent);
                $interface->setUrl('http://api.symfony.com/3.2/'. str_replace('\\', '/', $element->nodeValue).'/'.$item->nodeValue.'.html');
                $interface->setNamespace($namespace);
                $em->persist($interface);
            }
        }
        $em->flush();
*/
    }

    public function addRecursion($nodeUrl, NamespaceSymfony $parent = null)
    {
        $html = file_get_contents($nodeUrl);
        $crawler = new Crawler($html);
        $nodes = $crawler->filter('div.namespace-list > a');
        $nodes_class = $crawler->filter('div.col-md-6 > a');
        $nodes_inter = $crawler->filter('div.col-md-6 > em > a');
        $em = $this->getContainer()->get('doctrine')->getManager();

        //if ($nodes->count() > 0) {
            foreach($nodes as $node) {
                $url = 'http://api.symfony.com/3.2/' . str_replace('../', '', $node->getAttribute('href'));
                $namespace = new NamespaceSymfony();
                $namespace->setName($node->textContent);
                $namespace->setUrl($url);
                $namespace->setParent($parent);

                $em->persist($namespace);

                $this->addRecursion('http://api.symfony.com/3.2/' . str_replace('../', '', $node->getAttribute('href')), $namespace);
                var_dump('http://api.symfony.com/3.2/Symfony/'.str_replace('../', '', $node->getAttribute('href')));
            }
        //}

        if ($nodes_class->count() > 0) {
            foreach($nodes_class as $node) {
   //           var_dump('class - http://api.symfony.com/3.2/'.str_replace('../','', $node->getAttribute('href')));
            }
        }

        if ($nodes_inter->count() > 0) {
            foreach($nodes_inter as $node) {
   //           var_dump('inter - http://api.symfony.com/3.2/'.str_replace('../','', $node->getAttribute('href')));
            }
        }

        $em->flush();
    }
}