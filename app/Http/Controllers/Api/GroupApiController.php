<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BatchContactGroupRequest;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\GroupCollection;
use App\Http\Resources\GroupResource;
use App\Http\Resources\PermissionIssueResource;
use App\Http\Traits\ApiPermissionTrait;
use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupApiController extends Controller
{
    use ApiPermissionTrait;


    /**
     * Groups
     *
     * Get a paginated list of groups from your current department. Token Permissions may prevent this from working.
     *
     * @group Groups
     * @authenticated
     * @headers
     * @response {
     *        "status": 200,
     *
     *          "data": {
     *               "id": 6,
     *               "name": 44,
     *                "contacts": 3
     *               "created_at": "2023-09-26T13:14:23.000000Z",
     *              }
     *   }
     * @return GroupCollection
     */
    public function index(Request $request)
    {

        if(!$this->permissionCheck('read',$request->user())){
            return new PermissionIssueResource(\request());
        }
         return new GroupCollection(Group::get());
    }



    /**
     * Create Group
     *
     * Creating group for contact grouping. Token Permissions may prevent this from working.
     *
     * @param StoreGroupRequest $request
     *
     * @bodyParam name string required
     *   name of the group you wish to create.Example: New Group name
     *
     * @authenticated
     * @group Contact Groups
     *
     * @response {
     *       "status": 201,
     *
     *         "data": {
     *              "id": 6,
     *              "name": 44,
     *              "created_at": "2023-09-26T13:14:23.000000Z",
     *              "updated_at": "2023-09-26T13:14:23.000000Z"
     *      }
     *  }
     *
     * @return GroupResource
     */
    public function store(StoreGroupRequest $request)
    {

        if(!$this->permissionCheck('create',$request->user())){
            return new PermissionIssueResource(\request());
        }
        try{
            $group = Group::create([
                'name'=> ucfirst($request['name']),
                'team_id'=>$request->user()->currentTeam->id
            ]);
            return new GroupResource($group);
        }catch (\Throwable $throwable){
            return  new  ErrorResource($throwable);
        }
    }



    /**
     * Move To Group
     *
     * Move contacts to a specific contact group. Token Permissions may prevent this from working.
     *
     * @bodyParam group_id number required
     *  The id of the group. Example: 1
     *
     * @bodyParam batch array required
     *  a list of contact id's that you would like placed into the selected group.Example: [{"contact_id":1},{"contact_id":2}]
     *
     *
     * @authenticated
     * @group Contact Groups
     *
     *
     * @response {
     *       "status": 201,
     *        "message": "10 contacts moved"
     *
     *  }
     *
     **/

    public function moveContactToGroup(BatchContactGroupRequest $request){

        if(!$this->permissionCheck('update',$request->user())){
            return new PermissionIssueResource(\request());
        }


        //check Group is in current department
        $group = Group::find($request->group_id);

        if(!$group){
            return response()->json(['status'=>401,'message'=>'please use a valid group id ']);
        }
        $count = 0;
        foreach($request['batch'] as $apply) {


          $contact =   Contact::find($apply['contact_id']);




          if($contact){
              $count++;
              ContactGroup::updateOrCreate([
                  'group_id' => $group->id,
                  'contact_id'   => $contact->id,
              ]);
          }
        }

        return response()->json(['status'=>201,'message'=>$count.' contacts moved']);
        //Batch request
    }


    /**
     * Remove From Group
     *
     * remove contacts from a specific contact group. Token Permissions may prevent this from working.
     *
     * @authenticated
     * @group Contact Groups
     *
     * @bodyParam group_id number required
     *   The id of the group. Example: 1
     *
     * @bodyParam batch array required
     *   a list of contact id's that you would like remove from the selected group.  Example: [{"contact_id":1},{"contact_id":2}]
     *
     *
     * @response {
     *       "status": 201,
     *        "message": "10 contacts removed from group"
     *
     *  }
     *
     **/

    public function removeContactFromGroup(BatchContactGroupRequest $request){

        if(!$this->permissionCheck('update',$request->user())){
            return new PermissionIssueResource(\request());
        }

        //check Group is in current department
        $group = Group::find($request->group_id);

        if(!$group){
            return response()->json(['status'=>401,'message'=>'please use a valid group id ']);
        }

        $count = 0;
        foreach($request['batch'] as $apply) {


            $contact =   Contact::where('team_id',$request->user()->currentTeam->id)->find($apply['contact_id']);

            if($contact){
                $count++;
                ContactGroup::where([
                    'group_id' => $group->id,
                    'contact_id'   => $contact->id,
                ])->delete();
            }
        }

        return response()->json(['status'=>201,'message'=>$count.' contacts removed from group']);
        //Batch request
    }



    /**
     * Delete Group
     *
     * Remove a specific contact group. Token Permissions may prevent this from working.
     *
     * @authenticated
     * @group Contact Groups
     * @pathParam id integer required
     *  The id of the group required
     *
     * @response {
     *       "status": 200,
     *        "message": "group removed"
     *
     *  }
     *
     **/

    public function destroy($id)
    {
        if(!$this->permissionCheck('delete',\request()->user())){
            return new PermissionIssueResource(\request());
        }
        try{
            if(ContactGroup::where('group_id',$id)->count() == 0){
                Group::findOrFail($id)->delete();
                return response()->json(['status'=>200,'message'=>'group removed']);
            }else{
                return response()->json(['status'=>401,'message'=>'remove contacts before deleting group']);
            }
        }catch (\Throwable $throwable){
            return  new  ErrorResource($throwable);
        }
    }






}
