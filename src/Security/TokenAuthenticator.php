<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @inheritdoc
     */
    public function supports(Request $request): bool
    {
        return $request->headers->has('X-Auth-Token');
    }

    /**
     * @inheritdoc
     */
    public function getCredentials(Request $request)
    {
        return $request->headers->get('X-Auth-Token');
    }

    /**
     * @inheritdoc
     */
    public function getUser(
        $credentials,
        UserProviderInterface $userProvider
    ): ?UserInterface {
        if (null === $credentials) {
            return null;
        }

        return $userProvider->loadUserByUsername($credentials);
    }

    /**
     * @inheritdoc
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        $providerKey
    ): ?Response {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function onAuthenticationFailure(
        Request $request,
        AuthenticationException $exception
    ): JsonResponse {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @inheritdoc
     */
    public function start(
        Request $request,
        AuthenticationException $authException = null
    ): JsonResponse {
        $data = [
            'message' => 'Authentication Required'
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @inheritdoc
     */
    public function supportsRememberMe(): bool
    {
        return false;
    }
}
