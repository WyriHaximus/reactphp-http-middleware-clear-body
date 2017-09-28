<?php declare(strict_types=1);

namespace WyriHaximus\React\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use function React\Promise\resolve;
use function RingCentral\Psr7\stream_for;

final class ClearBodyMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        return resolve($next($request->withBody(stream_for(''))));
    }
}
