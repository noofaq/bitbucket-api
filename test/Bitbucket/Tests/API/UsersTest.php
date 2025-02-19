<?php

namespace Bitbucket\Tests\API;

use Bitbucket\API\Users;

class UsersTest extends TestCase
{
    /** @var Users */
    private $users;

    protected function setUp(): void
    {
        parent::setUp();
        $this->users = $this->getApiMock(Users::class);
    }

    public function testGetUserPublicInformation()
    {
        $endpoint = '/2.0/users/john-doe';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->users->get('john-doe');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetUserRepositories()
    {
        $endpoint = '/2.0/repositories/john-doe';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->users->repositories('john-doe');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetInvitationsInstance()
    {
        $this->assertInstanceOf(Users\Invitations::class, $this->users->invitations());
    }

    public function testGetSshKeysInstance()
    {
        $this->assertInstanceOf(Users\SshKeys::class, $this->users->sshKeys());
    }
}
