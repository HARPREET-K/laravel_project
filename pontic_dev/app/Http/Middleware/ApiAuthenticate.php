<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use DB;
use App\Models\ApiTokens;
//use App\Token as Token;
class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
                
        $postdata = $request->all();
        
        if(isset($postdata['device_id']) && $postdata['device_id'] != null && isset($postdata['auth_token']) && $postdata['auth_token'] != null){
            $matchThese = ['device_id' => $postdata['device_id'], 'auth_token' => $postdata['auth_token']];
            $is_token_valid = ApiTokens::where($matchThese)->first();
            if(!$is_token_valid){
                echo json_encode(array('status_id' => 0, 'message' => 'Invalid auth token.'));
                return;
            }
        }else{
            echo json_encode(array('status_id' => 0, 'message' => 'Input parameters missing...'));
            return;
        }
        
        
        return $next($request);
        
    }
}

