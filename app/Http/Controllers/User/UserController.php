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
                    '080507F5-DA58-45D2-B516-FD1BEFE7345B', // Client ID
                    '6vi17be2fn0o0o8gw4g84c4g' // Client Secret
                );
         
            $oidc->setRedirectURL('http://localhost:9998/auth'); // must be the same as you registered
            $oidc->addScope('email group integra phone profile role openid secret'); //must be the same as you registered
            
            // remove this if in production mode
            $oidc->setVerifyHost(false);
            $oidc->setVerifyPeer(false);
            
            $oidc->authenticate(); //call the main function of myITS SSO login
            
            
            $attr = $oidc->requestUserInfo();
            session(['id_token' => $oidc->getIdToken(), 'user_attr' => $attr]);
            session()->save();
            
            return $oidc;
            
        } catch (OpenIDConnectClientException $e) {
            echo 'test';
            echo $e->getMessage();
        }
        
        // Auth::loginUsingId(2);
        // return redirect()->route('dashboard.index');

        return null;
    }
    
    public function authenticate(Request $request)
    {
        // echo 'test2';
        // die;
        $oidc = UserController::login();
        $user = DB::select('SELECT id FROM users WHERE nip = ?', [session('user_attr')->reg_id]);
        
        if(count($user) == 0)
        {
            $user = DB::select('SELECT * FROM v_user_easet WHERE email = ? or username = ?', 
            [session('user_attr')->email, session('user_attr')->preferred_username])[0];
            $unit = DB::select('SELECT id_easet, code FROM v_unit_easet WHERE id_easet = ?', [$user->current_unit_id])[0];
            $id = DB::table('users')->insertGetID([
                'nip' => session('user_attr')->reg_id,
                'username' => session('user_attr')->preferred_username,
                'nama_user' => $user->nama_user,
                'unit' => $unit->code,
                'nama_unit' => $unit->nama_unit,
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
