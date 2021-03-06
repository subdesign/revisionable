<?php

namespace Sofa\Revisionable\Adapters;

use Tymon\JWTAuth\JWTAuth as JWT;
use Sofa\Revisionable\UserProvider;

class JwtAuth implements UserProvider
{
    /**
     * Auth provider instance.
     *
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $provider;

    /**
     * Field from the user to be saved as author of the action.
     *
     * @var string
     */
    protected $field;

    /**
     * Create adapter instance for Illuminate Guard.
     *
     * @param \Tymon\JWTAuth\JWTAuth $provider
     * @param string                 $field
     */
    public function __construct(JWT $provider, $field = null)
    {
        $this->provider = $provider;
        $this->field = $field;
    }

    /**
     * Get identifier of the currently logged in user.
     *
     * @return string|null
     */
    public function getUser()
    {
        if ($user = $this->provider->parseToken()->toUser()) {
            return ($field = $this->field) ? (string) $user->{$field} : $this->provider->getIdentifier();
        }
    }

    /**
     * Get id of the currently logged in user.
     *
     * @return integer|null
     */
    public function getUserId()
    {
        if ($user = $this->provider->parseToken()->toUser()) {
            return $user->getKey();
        }
    }
}
