<?php

namespace Directus\Authentication\Sso\Provider\custom\centralserver;

use Directus\Authentication\Sso\TwoSocialProvider;
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessToken;

class Provider extends TwoSocialProvider
{
    /**
     * @var GenericProvider
     */
    protected $provider = null;

    /**
     * @inheritdoc
     */
    public function getScopes()
    {
        return [
            'email'
        ];
    }

    /**
     * Creates the provider oAuth client
     *
     * @return GenericProvider
     */
    protected function createProvider()
    {
        $this->provider = new GenericProvider([
            'clientId'          => $this->config->get('clientId'),
            'clientSecret'          => $this->config->get('clientSecret'),
            'urlAuthorize'          => $this->config->get('urlAuthorize'),
            'urlAccessToken'          => $this->config->get('urlAccessToken'),
            'urlResourceOwnerDetails'          => $this->config->get('urlResourceOwnerDetails'),
        ]);


        return $this->provider;
    }


    /**
     * Gets the resource owner email
     *
     * @param AccessToken $token
     *
     * @return string
     */
    protected function getResourceOwnerEmail(AccessToken $token)
    {
        $user = $this->provider->getResourceOwner($token);

        return $user->toArray()['email'];
    }
}
