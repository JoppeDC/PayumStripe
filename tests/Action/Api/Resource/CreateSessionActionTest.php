<?php

namespace Tests\Prometee\PayumStripeCheckoutSession\Action\Api\Resource;

use ArrayObject;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\GatewayInterface;
use PHPUnit\Framework\TestCase;
use Prometee\PayumStripeCheckoutSession\Action\Api\Resource\CreateResourceActionInterface;
use Prometee\PayumStripeCheckoutSession\Action\Api\Resource\CreateSessionAction;
use Prometee\PayumStripeCheckoutSession\Api\KeysInterface;
use Prometee\PayumStripeCheckoutSession\Request\Api\Resource\CreateSession;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Tests\Prometee\PayumStripeCheckoutSession\Action\Api\ApiAwareActionTestTrait;

class CreateSessionActionTest extends TestCase
{
    use ApiAwareActionTestTrait;

    /**
     * @test
     */
    public function shouldImplements()
    {
        $action = new CreateSessionAction();

        $this->assertInstanceOf(ApiAwareInterface::class, $action);
        $this->assertInstanceOf(ActionInterface::class, $action);
        $this->assertNotInstanceOf(GatewayInterface::class, $action);

        $this->assertInstanceOf(CreateResourceActionInterface::class, $action);
    }

    /**
     * @test
     */
    public function shouldCreateASession()
    {
        $model = new ArrayObject([]);

        $apiMock = $this->createApiMock();

        $action = new CreateSessionAction();
        $action->setApiClass(KeysInterface::class);
        $action->setApi($apiMock);

        $this->assertEquals(Session::class, $action->getApiResourceClass());

        $request = new CreateSession($model);

        $this->assertTrue($action->supportAlso($request));

        $this->expectException(ApiErrorException::class);

        $action->execute($request);
    }
}