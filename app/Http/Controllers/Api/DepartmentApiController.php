<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentChangeRequest;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\DeptCollection;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\GroupCollection;
use App\Http\Resources\PermissionIssueResource;
use App\Http\Traits\ApiPermissionTrait;
use App\Models\Team;
use Illuminate\Http\Request;

class DepartmentApiController extends Controller
{


    use ApiPermissionTrait;


    /**
     * List Departments
     *
     * Get a paginated list of Departments and the associated senders with sender id`s. Token Permissions may prevent this from working.
     * Sender ID Value acquired by calling /api/departments
     *
     * @group Departments
     * @authenticated
     * @headers
     * @response {
     *        "status": 200,
     *
 *              "data": [
     *             {
     *              "id": 1,
     *              "name": "Testing",
     *              "credits": 0,
 *                  "senders": [
     *                  {
     *                  "id": 1,
 *                      "sender_name": "dbfb"
     *                  }
     *                  ],
     *              "created_at": "2023-07-06T13:35:55.000000Z"
     *              }
     *              ]
     *
     *    }
     * @return DeptCollection
     */

    public function index(Request $request){
        if(!$this->permissionCheck('read',$request->user())){
            return new PermissionIssueResource(\request());
        }

       return new DeptCollection($request->user()->allTeams());

    }


    /**
     * Change Departments
     *
     * Change to a different department. Token Permissions may prevent this from working.
     *
     * @group Departments
     * @authenticated
     * @headers
     *
     * @bodyParam departmentId integer required
     *  ID of department to change too.
     *
     * @response {
     *        "status": 200,
     *
     *          "data": {
     *               "id": 6,
     *               "name": 44,
     *               "created_at": "2023-09-26T13:14:23.000000Z",
     *              }
     *   }
     * @return DeptCollection
     */
    public function changeDepartment(DepartmentChangeRequest $request){

        if(!$this->permissionCheck('update',$request->user())){
            return new PermissionIssueResource(\request());
        }



        try{
            $team = Team::findOrFail($request->departmentId);
            if($request->user()->belongsToTeam($team) || $request->user()->ownsTeam($team)){
                $request->user()->switchTeam($team);
                    return new DepartmentResource($team);
            }else{
                return new PermissionIssueResource(\request());
            }


        }catch (\Throwable $throwable){

            return  new  ErrorResource($throwable);
        }









    }
}
