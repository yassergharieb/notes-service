<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $unAuthRes = Response()->json(
            [
                'message' => 'please login',
            ],
            Response::HTTP_UNAUTHORIZED
        );

        $token = $request->headers->get('authorization');

        if (empty($token)) {
            return $unAuthRes;
        }

        $token = explode(' ', $token);
        if (!isset($token[1])) {
            return $unAuthRes;
        }

        $token = $token[1];

        //simulate logout
        //$notValid = Cache::get($token);
        //if (!empty($notValid)) {
        //    var_dump('3');
        //    return $unAuthRes;
        //}

        try {
            $data = JWT::decode($token, new Key('foobar', 'HS256'));

            if (date('Y-m-d H:i:s') > $data->expiredAt) {
                return $unAuthRes;
            }

            $request->headers->add([
                'user_id' => $data->userId,
                'username' => $data->username,
            ]);
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());

            return $unAuthRes;
        }

        return $next($request);
    }
}
