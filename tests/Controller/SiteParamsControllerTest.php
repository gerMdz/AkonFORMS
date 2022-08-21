<?php

namespace App\Test\Controller;

use App\Entity\SiteParams;
use App\Repository\SiteParamsRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SiteParamsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private SiteParamsRepository $repository;
    private string $path = '/site/params/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(SiteParams::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('SiteParam index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'site_param[url]' => 'Testing',
            'site_param[name]' => 'Testing',
            'site_param[email_contact]' => 'Testing',
            'site_param[title]' => 'Testing',
            'site_param[description]' => 'Testing',
            'site_param[image]' => 'Testing',
            'site_param[type]' => 'Testing',
            'site_param[author]' => 'Testing',
        ]);

        self::assertResponseRedirects('/site/params/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new SiteParams();
        $fixture->setUrl('My Title');
        $fixture->setName('My Title');
        $fixture->setEmail_contact('My Title');
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setImage('My Title');
        $fixture->setType('My Title');
        $fixture->setAuthor('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('SiteParam');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new SiteParams();
        $fixture->setUrl('My Title');
        $fixture->setName('My Title');
        $fixture->setEmail_contact('My Title');
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setImage('My Title');
        $fixture->setType('My Title');
        $fixture->setAuthor('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'site_param[url]' => 'Something New',
            'site_param[name]' => 'Something New',
            'site_param[email_contact]' => 'Something New',
            'site_param[title]' => 'Something New',
            'site_param[description]' => 'Something New',
            'site_param[image]' => 'Something New',
            'site_param[type]' => 'Something New',
            'site_param[author]' => 'Something New',
        ]);

        self::assertResponseRedirects('/site/params/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getUrl());
        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getEmail_contact());
        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getImage());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getAuthor());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new SiteParams();
        $fixture->setUrl('My Title');
        $fixture->setName('My Title');
        $fixture->setEmail_contact('My Title');
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setImage('My Title');
        $fixture->setType('My Title');
        $fixture->setAuthor('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/site/params/');
    }
}
