<?php

/*
 * This file is part of Flarum.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flarum\Tests\unit\Api\ExceptionHandler;

use Exception;
use Flarum\Api\ExceptionHandler\TokenMismatchExceptionHandler;
use Flarum\Http\Exception\TokenMismatchException;
use PHPUnit\Framework\TestCase;

class TokenMismatchExceptionHandlerTest extends TestCase
{
    private $handler;

    public function setUp()
    {
        $this->handler = new TokenMismatchExceptionHandler;
    }

    public function test_it_handles_recognisable_exceptions()
    {
        $this->assertFalse($this->handler->manages(new Exception));
        $this->assertTrue($this->handler->manages(new TokenMismatchException()));
    }

    public function test_managing_exceptions()
    {
        $response = $this->handler->handle(new TokenMismatchException);

        $this->assertEquals(400, $response->getStatus());
        $this->assertEquals([
            [
                'status' => '400',
                'code' => 'csrf_token_mismatch'
            ]
        ], $response->getErrors());
    }
}
