<?php

namespace App\Oauth\Controllers\Api;

use App\Oauth\Models\User;
use App\Oauth\Repository\AccessTokenRepository;
use App\Oauth\Repository\ScopeRepository;
use Defuse\Crypto\Key;
use App\Oauth\Repository\ClientRepository;
use GuzzleHttp\Psr7\ServerRequest;
use League\OAuth2\Server\AuthorizationServer;
use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

/**
 * Class BookController
 * @property \League\OAuth2\Server\AuthorizationServer oauth2Server injected into DI
 * @package App\Controllers
 */

class AuthController extends Controller
{
    
    public function authorizeAction() {
        $serverResponse = new \GuzzleHttp\Psr7\Response();
        try {
            $request = ServerRequest::fromGlobals();

            $authRequest = $this->oauth2Server->validateAuthorizationRequest($request);
            $authRequest->setUser(new User([
                'id' => '1'
            ]));
            $authRequest->setAuthorizationApproved(true);
            $response =  $this->oauth2Server->completeAuthorizationRequest($authRequest, $serverResponse);
            $redirectUrl = $response->getHeaders()['Location'][0];
            $this->sendJSON(json_decode($response->getBody()));
//            var_dump($response->getBody());
        } catch (\Exception $exception) {
            $this->sendJSON($exception->getMessage());
        }
    }


    /*
    * Expectation
    * @method POST
    * @required body : grant_type client_credentials
    * @required body : client_id
    * @optional body : client_secret
    * @optional body : scope *Space delimited*
    */
    public function tokenAction()
    {
        $serverResponse = new \GuzzleHttp\Psr7\Response();
        $request = ServerRequest::fromGlobals();
        $response = $this->oauth2Server->respondToAccessTokenRequest(ServerRequest::fromGlobals(), $serverResponse);
        $this->sendJSON($response->getBody());
    }

    private function sendJSON($response) {
        $httpResponse = new Response();
        $httpResponse->setContentType('application/json');
        $httpResponse->setContent($response);
        $httpResponse->send();
    }
}