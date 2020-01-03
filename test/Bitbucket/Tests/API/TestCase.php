<?php

namespace Bitbucket\Tests\API;

use Buzz\Message\Response;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function getApiMock($class = null, $methods = array())
    {
        $class = is_null($class) ? '\Bitbucket\API\Api' : $class;
        $methods = array_merge(
            array('requestGet', 'requestPost', 'requestPut', 'requestDelete'),
            $methods
        );

        $client = $this->getHttpClientMock();

        return $this->getMockBuilder($class)
            ->setMethods($methods)
            ->setConstructorArgs(array(array(), $client))
            ->getMock();
    }

    protected function getBrowserMock()
    {
        return $this->getMockBuilder('\Buzz\Client\ClientInterface')
            ->setMethods(array('setTimeout', 'setVerifyPeer', 'send'))
            ->getMock();
    }

    protected function getTransportClientMock()
    {
        $client = $this->getBrowserMock();

        $client->expects($this->any())->method('setTimeout')->with(10);
        $client->expects($this->any())->method('setVerifyPeer')->with(true);
        $client->expects($this->any())->method('send');

        return $client;
    }

    protected function getHttpClientMock()
    {
        $transportClient = $this->getTransportClientMock();

        return $this->getMockBuilder('Bitbucket\API\HTTP\Client')
            ->setMethods(array('get', 'post', 'put', 'delete'))
            ->setConstructorArgs(array(array(), $transportClient))
            ->getMock();
    }

    protected function getHttpClient()
    {
        return new \Bitbucket\API\Http\Client(array(), $this->getTransportClientMock());
    }

    protected function fakeResponse($data)
    {
        $response = new Response();

        $response->setContent(json_encode($data));

        return $response;
    }

    protected function getClassMock($class, $httpClient)
    {
        /** @var \Bitbucket\API\Api $obj */
        $obj = new $class();
        $obj->setClient($httpClient);

        return $obj;
    }

    protected function getMethod($class, $name)
    {
        $class = new \ReflectionClass($class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}
