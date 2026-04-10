<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Illuminate\Support\Arr;
use RuntimeException;

class FirebaseCustomTokenService
{
    public function createTokenForUser(string $uid, array $customClaims = []): string
    {
        $credentials = $this->credentials();
        $issuedAt = time();

        $payload = [
            'iss' => $credentials['client_email'],
            'sub' => $credentials['client_email'],
            'aud' => 'https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit',
            'iat' => $issuedAt,
            'exp' => $issuedAt + 3600,
            'uid' => $uid,
        ];

        if ($customClaims !== []) {
            $payload['claims'] = $customClaims;
        }

        return JWT::encode($payload, $credentials['private_key'], 'RS256');
    }

    public function projectId(): string
    {
        return (string) Arr::get($this->credentials(), 'project_id', config('firebase.project_id'));
    }

    protected function credentials(): array
    {
        $path = config('firebase.service_account_json');

        if (! $path) {
            throw new RuntimeException('Firebase service account path is not configured.');
        }

        if (! is_file($path)) {
            throw new RuntimeException("Firebase service account file was not found at [{$path}].");
        }

        $decoded = json_decode(file_get_contents($path), true);

        if (! is_array($decoded)) {
            throw new RuntimeException('Firebase service account file is not valid JSON.');
        }

        foreach (['project_id', 'client_email', 'private_key'] as $requiredKey) {
            if (blank(Arr::get($decoded, $requiredKey))) {
                throw new RuntimeException("Firebase service account is missing [{$requiredKey}].");
            }
        }

        return $decoded;
    }
}
