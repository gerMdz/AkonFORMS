<?php

namespace App\Test\Controller;

use App\Entity\Address;
use App\Repository\AddressRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddressControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AddressRepository $repository;
    private string $path = '/address/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Address::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Address index');

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
            'address[address_text]' => 'Testing',
            'address[address2]' => 'Testing',
            'address[address3]' => 'Testing',
            'address[district]' => 'Testing',
            'address[location]' => 'Testing',
            'address[state]' => 'Testing',
            'address[country]' => 'Testing',
            'address[city]' => 'Testing',
            'address[postal_code]' => 'Testing',
            'address[createdAt]' => 'Testing',
            'address[updatedAt]' => 'Testing',
        ]);

        self::assertResponseRedirects('/address/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Address();
        $fixture->setAddress_text('My Title');
        $fixture->setAddress2('My Title');
        $fixture->setAddress3('My Title');
        $fixture->setDistrict('My Title');
        $fixture->setLocation('My Title');
        $fixture->setState('My Title');
        $fixture->setCountry('My Title');
        $fixture->setCity('My Title');
        $fixture->setPostal_code('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Address');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Address();
        $fixture->setAddress_text('My Title');
        $fixture->setAddress2('My Title');
        $fixture->setAddress3('My Title');
        $fixture->setDistrict('My Title');
        $fixture->setLocation('My Title');
        $fixture->setState('My Title');
        $fixture->setCountry('My Title');
        $fixture->setCity('My Title');
        $fixture->setPostal_code('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'address[address_text]' => 'Something New',
            'address[address2]' => 'Something New',
            'address[address3]' => 'Something New',
            'address[district]' => 'Something New',
            'address[location]' => 'Something New',
            'address[state]' => 'Something New',
            'address[country]' => 'Something New',
            'address[city]' => 'Something New',
            'address[postal_code]' => 'Something New',
            'address[createdAt]' => 'Something New',
            'address[updatedAt]' => 'Something New',
        ]);

        self::assertResponseRedirects('/address/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getAddress_text());
        self::assertSame('Something New', $fixture[0]->getAddress2());
        self::assertSame('Something New', $fixture[0]->getAddress3());
        self::assertSame('Something New', $fixture[0]->getDistrict());
        self::assertSame('Something New', $fixture[0]->getLocation());
        self::assertSame('Something New', $fixture[0]->getState());
        self::assertSame('Something New', $fixture[0]->getCountry());
        self::assertSame('Something New', $fixture[0]->getCity());
        self::assertSame('Something New', $fixture[0]->getPostal_code());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Address();
        $fixture->setAddress_text('My Title');
        $fixture->setAddress2('My Title');
        $fixture->setAddress3('My Title');
        $fixture->setDistrict('My Title');
        $fixture->setLocation('My Title');
        $fixture->setState('My Title');
        $fixture->setCountry('My Title');
        $fixture->setCity('My Title');
        $fixture->setPostal_code('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/address/');
    }
}
