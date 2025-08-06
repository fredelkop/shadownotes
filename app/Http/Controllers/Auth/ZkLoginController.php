<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Services\ZkLoginService;
use App\Models\User;

class ZkLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['openid','email','profile'])
            ->stateless()
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Create or fetch the user by Google email
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            ['name'    => $googleUser->getName(),
             'google_id' => $googleUser->getId()]
        );

        // Issue a temporary Sanctum token for zkLogin initialization
        $tempToken = $user->createToken('zk-init')->plainTextToken;

        return response()->json([
            'temp_token' => $tempToken,
            'address'    => $user->sui_address // may be null initially
        ]);
    }

    public function verifyZkLogin(Request $req, ZkLoginService $zk)
    {
        $req->validate([
            'proof'   => 'required|string',
            'address' => 'required|string',
        ]);

        $user = $req->user();
        if (! $zk->verifyProof($req->proof, $req->address)) {
            return response()->json(['error' => 'Invalid proof'], 422);
        }

        // Save the verified Sui address
        $user->sui_address = $req->address;
        $user->save();

        // Issue your permanent API token
        $apiToken = $user->createToken('api')->plainTextToken;
        return response()->json(['token' => $apiToken]);
    }
}
