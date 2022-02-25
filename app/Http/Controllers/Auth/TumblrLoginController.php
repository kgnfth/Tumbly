<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Tumblr\API\Client;

class TumblrLoginController extends Controller
{
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function auth()
    {
        $requestHandler = $this->client->getRequestHandler();
        $requestHandler->setBaseUrl('https://www.tumblr.com');

        $response = $requestHandler->request('POST', 'oauth/request_token', []);

        parse_str((string) $response->body, $tokens);

        session(['oauth_token' => $tokens['oauth_token']]);
        session(['oauth_token_secret' => $tokens['oauth_token_secret']]);
        session(['oauth_callback_confirmed' => $tokens['oauth_callback_confirmed']]);

        return redirect()->away("https://www.tumblr.com/oauth/authorize?oauth_token=" . $tokens['oauth_token']);
    }

    public function callback()
    {
        $requestHandler = $this->client->getRequestHandler();

        $requestHandler->setBaseUrl('https://www.tumblr.com');

        $response = $requestHandler->request('POST', 'oauth/access_token', [
            'oauth_verifier' => trim(request()->oauth_verifier),
        ]);

        try {
            parse_str($response->body, $tokens);
            session(['oauth_token' => $tokens['oauth_token']]);
            session(['oauth_token_secret' => $tokens['oauth_token_secret']]);
        } catch (\Exception $e) {
            if ($e->getCode() == 0) {
                session()->flush();
                laraflash('Not Autorized !', $e)->danger();
                return redirect('/');
            }
        }

        if ($response->status == 200) {
            return redirect()->route('home');
        } else {
            echo "i dont know what to do here yet";
        }
    }
}
