<?php

namespace App\Http\Controllers\Api\V1;

//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PermissionResource;

class PermissionsController extends Controller
{
    //Get a user's permissions list
    public function index(Request $request){
        $permissions = $request->user()->getAllPermissions();

        PermissionResource::wrap('data');
        return PermissionResource::collection($permissions);
    }
}
