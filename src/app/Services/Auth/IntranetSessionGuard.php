<?php

namespace App\Services\Auth;

use Illuminate\Contracts\Auth\StatefulGuard;
use Session;

class IntranetSessionGuard implements StatefulGuard
{
    use \Illuminate\Auth\GuardHelpers;

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check() {
        return session('authenticatedUser') == 'intranet';
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest() {
        return session('authenticatedUser') != 'intranet';
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user() {
        return null;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id() {
        return null;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = []) {

        return array_key_exists($credentials, 'legacy_username') && array_key_exists($credentials, 'legacy_password')
            && !empty($credentials['legacy_username']) && !empty($credentials['legacy_password']);
    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    public function setUser(\Illuminate\Contracts\Auth\Authenticatable $user) {
        //Do not do anything, not supported.
    }





    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param  array  $credentials
     * @param  bool   $remember
     * @return bool
     */
    public function attempt(array $credentials = [], $remember = false) {

        $client = new \GuzzleHttp\Client();
        $payload = ['json' => ['legacy_username' => $credentials['legacy_username'], 'legacy_password' => $credentials['legacy_password']]];
        $req = $client->post('oms-legacy/api/intranet/login', $payload);
        $intranetLogin = json_decode($req->getBody())->success == 'true';

        if ($intranetLogin) {
            session(['authenticatedUser' => 'intranet']);
        } else {
            session(['authenticatedUser' => '']);
        }

        return $intranetLogin;

    }

    /**
     * Log a user into the application without sessions or cookies.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function once(array $credentials = []) {
        throw new Exception('Not implemented');
    }

    /**
     * Log a user into the application.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  bool  $remember
     * @return void
     */
    public function login(\Illuminate\Contracts\Auth\Authenticatable $user, $remember = false) {
        throw new Exception('Not implemented');
    }

    /**
     * Log the given user ID into the application.
     *
     * @param  mixed  $id
     * @param  bool   $remember
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function loginUsingId($id, $remember = false) {
        throw new Exception('Not implemented');
    }

    /**
     * Log the given user ID into the application without sessions or cookies.
     *
     * @param  mixed  $id
     * @return bool
     */
    public function onceUsingId($id) {
        throw new Exception('Not implemented');
    }

    /**
     * Determine if the user was authenticated via "remember me" cookie.
     *
     * @return bool
     */
    public function viaRemember() {
        throw new Exception('Not implemented');
    }

    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout() {
        session(['authenticatedUser' => '']);
    }
}
