<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\SwiftmailerBundle\DataCollector\MessageDataCollector;

class MiscControllerTest extends WebTestCase
{
    
    public function testSubmitContactRequestToAdministrators()
    {
        $client = static::createClient();
        $client->enableProfiler();
        
        $crawler = $client->request('GET', '/login');
        
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertSame(1, $crawler->filter('#menu')->count());
        $this->assertSame(1, $crawler->filter('#content')->count());
        $this->assertSame(1, $crawler->filter('#sidebar')->count());
        
        $crawler = $client->click($crawler->selectLink('Contact')->link());
        
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertSame(0, $crawler->filter('#contact_request li')->count());
        $this->assertSame('Submit a contact request', $crawler->filter('#content h2:first-child')->text());
        
        $form = $crawler->selectButton('Submit')->form();
        $form['contact_request[fullName]'] = 'Hugo Hamon';
        $form['contact_request[emailAddress]'] = 'invalid@foo';
        $form['contact_request[subject]'] = 'Pretty sweet site...';
        $form['contact_request[message]'] = 'This app is a piece of shit!';
        
        $crawler = $client->submit($form);
    
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertSame(2, $crawler->filter('#contact_request li')->count());
    
        $form = $crawler->selectButton('Submit')->form();
        $form['contact_request[emailAddress]'] = 'invalid@foo.com';
        $form['contact_request[message]'] = 'This app is a piece of gold!';
    
        $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect('/contact'));
        
        /** @var MessageDataCollector $collector */
        $collector = $client->getProfile()->getCollector('swiftmailer');
        $this->assertSame(1, $collector->getMessageCount());
        
        /** @var \Swift_Message $message */
        $message = $collector->getMessages()[0];
        $this->assertArrayHasKey('sysadmin@example.com', $message->getTo());
        
        $crawler = $client->followRedirect();
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertSame(1, $crawler->filter('.flash-success')->count());
    }
}
