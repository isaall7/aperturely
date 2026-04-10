<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\FirebaseCustomTokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class FirebaseAuthController extends Controller
{
    public function __construct(
        protected FirebaseCustomTokenService $firebaseCustomTokenService
    ) {
    }

    public function customToken(Request $request): JsonResponse
    {
        $user = $request->user();

        abort_unless($user, 401);

        try {
            $token = $this->firebaseCustomTokenService->createTokenForUser(
                (string) $user->id,
                ['role' => $user->role]
            );

            return response()->json([
                'token' => $token,
                'uid' => (string) $user->id,
                'project_id' => $this->firebaseCustomTokenService->projectId(),
            ]);
        } catch (Throwable $throwable) {
            report($throwable);

            return response()->json([
                'message' => 'Firebase custom token could not be generated.',
            ], 500);
        }
    }
}
