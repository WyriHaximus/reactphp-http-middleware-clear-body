<?php declare(strict_types=1);

namespace WyriHaximus\React\Tests\Http\Middleware;

use function Clue\React\Block\await;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Message\ServerRequest;
use function RingCentral\Psr7\stream_for;
use WyriHaximus\React\Http\Middleware\ClearBodyMiddleware;

/**
 * @internal
 */
final class ClearBodyMiddlewareTest extends TestCase
{
    public function testWithHeaders(): void
    {
        $request = (new ServerRequest('GET', 'https://example.com/'))->withBody(stream_for('foo.bar'));
        $middleware = new ClearBodyMiddleware();
        /** @var ServerRequestInterface $requestWithoutBody */
        $requestWithoutBody = await($middleware($request, function (ServerRequestInterface $request) {
            return $request;
        }), Factory::create());
        self::assertSame('', (string)$requestWithoutBody->getBody());
    }
}
