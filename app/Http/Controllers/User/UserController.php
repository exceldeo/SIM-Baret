<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

// ITS SSO
// require '/vendor/autoload.php';

use Its\Sso\OpenIDConnectClient;
use Its\Sso\OpenIDConnectClientException;

class UserController extends Controller
{
    public function login()
    {
        try {
            $oidc = new OpenIDConnectClient(
                    'https://dev-my.its.ac.id', // authorization_endpoint
                    env('MYITSSSO_CLIENTID'), // Client ID
                    env('MYITSSSO_CLIENTSECRET') // Client Secret
                );
         
            $oidc->setRedirectURL(env('MYITSSSO_AUTH_REDIRECT')); // must be the same as you registered
            $oidc->addScope(env('MYITSSSO_SCOPE')); //must be the same as you registered
            
            // remove this if in production mode
            $oidc->setVerifyHost(false);
            $oidc->setVerifyPeer(false);
        
            $oidc->authenticate(); //call the main function of myITS SSO login
        
            
            $attr = $oidc->requestUserInfo();
            session(['id_token' => $oidc->getIdToken(), 'user_attr' => $attr]);
            session()->save();

            return $oidc;
            
        } catch (OpenIDConnectClientException $e) {
            echo $e->getMessage();
        }

        return null;
    }
    
    public function authenticate(Request $request)
    {
        $oidc = UserController::login();
        $user = DB::select('SELECT id FROM users WHERE nip = ?', [session('user_attr')->reg_id]);
        
        if(count($user) == 0)
        {
            $user = DB::select('SELECT * FROM userdummy WHERE nip = ?', [session('user_attr')->reg_id])[0];
            $id = DB::table('users')->insertGetID([
                'nip' => $user->nip,
                'nama_user' => $user->nama_user,
                'unit' => $user->unit,
                'level' => '2'
                ]);
        }
        else
        {
            $id = $user[0]->id;
        }
        
        // var_dump(session('user_attr'));
        // return;
        Auth::loginUsingId($id);
        return redirect()->route('dashboard.index');
    }

    public function logout()
    {
        try {
			if (session()->has('id_token')) {
				Auth::logout();
				$accessToken = session('id_token');
				session()->forget('id_token');
				session()->save();

                $oidc = new OpenIDConnectClient(
                    'https://dev-my.its.ac.id', // authorization_endpoint
                    env('MYITSSSO_CLIENTID'), // Client ID
                    env('MYITSSSO_CLIENTSECRET') // Client Secret
                );
		
				// PROD: Remove
				$oidc->setVerifyHost(false);
				$oidc->setVerifyPeer(false);

				// Ask if user also wants to quit from myitssso
				$oidc->signOut($accessToken, env('MYITSSSO_POSTLOGOUT_REDIRECT'));
			}

			header("Location: " . env('MYITSSSO_POSTLOGOUT_REDIRECT'));
		} catch (OpenIDConnectClientException $e) {
			\Log::error('OIDC logout err: '.$e->getMessage());
		}
    }
}
