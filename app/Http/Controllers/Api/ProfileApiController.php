<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CreditResource;
use App\Http\Resources\PermissionIssueResource;
use App\Http\Resources\ProfileResource;
use App\Http\Traits\ApiPermissionTrait;
use Illuminate\Http\Request;

class ProfileApiController extends Controller
{
    use ApiPermissionTrait;
    /**
     * User Profile.
     * @group Account management
     * @authenticated
     * @headers
     * @return ProfileResource
     */

    public function index(Request $request)
    {
        if(!$this->permissionCheck('read',$request->user())){
            return new PermissionIssueResource(\request());
        }
        return new ProfileResource($request->user());
    }


    /**
     * Department Credits.
     * @group Credits
     * @authenticated
     * @headers
     * @return ProfileResource
     */

    public function credits(Request $request)
    {
        if(!$this->permissionCheck('read',$request->user())){
            return new PermissionIssueResource(\request());
        }
        return new CreditResource($request->user());
    }


}
