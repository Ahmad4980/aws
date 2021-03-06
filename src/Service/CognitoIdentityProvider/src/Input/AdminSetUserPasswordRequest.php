<?php

namespace AsyncAws\CognitoIdentityProvider\Input;

use AsyncAws\Core\Exception\InvalidArgument;
use AsyncAws\Core\Input;
use AsyncAws\Core\Request;
use AsyncAws\Core\Stream\StreamFactory;

final class AdminSetUserPasswordRequest extends Input
{
    /**
     * The user pool ID for the user pool where you want to set the user's password.
     *
     * @required
     *
     * @var string|null
     */
    private $UserPoolId;

    /**
     * The user name of the user whose password you wish to set.
     *
     * @required
     *
     * @var string|null
     */
    private $Username;

    /**
     * The password for the user.
     *
     * @required
     *
     * @var string|null
     */
    private $Password;

    /**
     * `True` if the password is permanent, `False` if it is temporary.
     *
     * @var bool|null
     */
    private $Permanent;

    /**
     * @param array{
     *   UserPoolId?: string,
     *   Username?: string,
     *   Password?: string,
     *   Permanent?: bool,
     *   @region?: string,
     * } $input
     */
    public function __construct(array $input = [])
    {
        $this->UserPoolId = $input['UserPoolId'] ?? null;
        $this->Username = $input['Username'] ?? null;
        $this->Password = $input['Password'] ?? null;
        $this->Permanent = $input['Permanent'] ?? null;
        parent::__construct($input);
    }

    public static function create($input): self
    {
        return $input instanceof self ? $input : new self($input);
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function getPermanent(): ?bool
    {
        return $this->Permanent;
    }

    public function getUserPoolId(): ?string
    {
        return $this->UserPoolId;
    }

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    /**
     * @internal
     */
    public function request(): Request
    {
        // Prepare headers
        $headers = [
            'Content-Type' => 'application/x-amz-json-1.1',
            'X-Amz-Target' => 'AWSCognitoIdentityProviderService.AdminSetUserPassword',
        ];

        // Prepare query
        $query = [];

        // Prepare URI
        $uriString = '/';

        // Prepare Body
        $bodyPayload = $this->requestBody();
        $body = empty($bodyPayload) ? '{}' : json_encode($bodyPayload);

        // Return the Request
        return new Request('POST', $uriString, $query, $headers, StreamFactory::create($body));
    }

    public function setPassword(?string $value): self
    {
        $this->Password = $value;

        return $this;
    }

    public function setPermanent(?bool $value): self
    {
        $this->Permanent = $value;

        return $this;
    }

    public function setUserPoolId(?string $value): self
    {
        $this->UserPoolId = $value;

        return $this;
    }

    public function setUsername(?string $value): self
    {
        $this->Username = $value;

        return $this;
    }

    private function requestBody(): array
    {
        $payload = [];
        if (null === $v = $this->UserPoolId) {
            throw new InvalidArgument(sprintf('Missing parameter "UserPoolId" for "%s". The value cannot be null.', __CLASS__));
        }
        $payload['UserPoolId'] = $v;
        if (null === $v = $this->Username) {
            throw new InvalidArgument(sprintf('Missing parameter "Username" for "%s". The value cannot be null.', __CLASS__));
        }
        $payload['Username'] = $v;
        if (null === $v = $this->Password) {
            throw new InvalidArgument(sprintf('Missing parameter "Password" for "%s". The value cannot be null.', __CLASS__));
        }
        $payload['Password'] = $v;
        if (null !== $v = $this->Permanent) {
            $payload['Permanent'] = (bool) $v;
        }

        return $payload;
    }
}
