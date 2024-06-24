<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\PermissionIssueResource;
use App\Http\Traits\ApiPermissionTrait;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ContactsApiController extends Controller
{

    use ApiPermissionTrait;
    /**
     * Contacts
     *
     * Get a paginated list of users from your current department. Token Permissions may prevent this from working.
     *
     * @group Contacts
     * @authenticated
     * @headers
     * @return ContactCollection
     */
    public function index(Request $request)
    {
        if(!$this->permissionCheck('read',$request->user())){
            return new PermissionIssueResource(\request());
        }


       return new ContactCollection(Contact::paginate());
    }


    /**
     * Store Contact
     *
     * Storing a contact to the system to send messages to. Token Permissions may prevent this from working.
     *
     * @param StoreContactRequest $request
     * @authenticated
     * @group Contacts
     * @bodyParam opt_in bool required
     *  if the customer is opted in to receive messages.
     *
     * @bodyParam number integer required
     * Number for customer without the +44 or first 0. Example: 7977000111
     *
     *
     * @bodyParam country_code integer required
     *  The country code for this number eg: 44 is UK Example:44
     *
     * @response {
     *       "status": 201,
     *       "success": true,
     *
     *         "data": {
     *              "id": 6,
     *              "country_code": 44,
     *              "number": 7852586219,
     *              "opted_in": false,
     *              "created_at": "2023-09-26T13:14:23.000000Z",
     *              "updated_at": "2023-09-26T13:14:23.000000Z"
     *      }
     *  }
     *
     * @return ContactResource
     */
    public function store(StoreContactRequest $request)
    {

        if(!$this->permissionCheck('create',$request->user())){
            return new PermissionIssueResource(\request());
        }
            try{
                $contact =   Contact::updateOrCreate(
                    [
                        'team_id' =>  $request->user()->currentTeam->id,
                        'country_code' => $request['country_code'],
                        'number' => $request['number'],
                    ],
                    [
                        'active' => $request['opt_in'] ?? false,
                        'country_code' => $request['country_code'],
                        'created_by' => $request->user()->id,
                    ]);

                return new ContactResource($contact);


            }catch (\Throwable $throwable){

                return  new  ErrorResource($throwable);

            }

    }

    /**
     * Get Contact
     *
     * Show a specific from the current department. Token Permissions may prevent this from working.
     *
     * @param StoreContactRequest $request
     * @authenticated
     * @group Contacts
     * @pathParam id integer required
     *  The id of the contact required
     *
     * @response {
     *       "status": 200,
     *       "success": true,
     *
     *         "data": {
     *              "id": 6,
     *              "country_code": 44,
     *              "number": 7852586219,
     *              "opted_in": false,
     *              "created_at": "2023-09-26T13:14:23.000000Z",
     *              "updated_at": "2023-09-26T13:14:23.000000Z"
     *      }
     *  }
     *
     * @return ContactResource
     */

    public function show($id)
    {


        if(!$this->permissionCheck('read',\request()->user())){
            return new PermissionIssueResource(\request());
        }

        try {

            return new ContactResource(Contact::findOrFail($id));
        }catch (\Throwable $throwable){


          return  new  ErrorResource($throwable);


        }

    }

    /**
     * Update Contact
     *
     * update a contact to the system. Token Permissions may prevent this from working.
     *
     * @param StoreContactRequest $request
     * @authenticated
     * @group Contacts
     * @pathParam id integer required
     *   The id of the contact required
     * @bodyParam opt_in bool required
     *  if the customer is opted in to receive messages.
     *
     * @bodyParam number integer required
     * Number for customer without the +44 or first 0. Example: 7977000111
     *
     *
     * @bodyParam country_code integer required
     *  The country code for this number eg: 44 is UK Example: 44
     *
     * @response {
     *       "status": 201,
     *       "success": true,
     *
     *         "data": {
     *              "id": 6,
     *              "country_code": 44,
     *              "number": 7852586219,
     *              "opted_in": false,
     *              "created_at": "2023-09-26T13:14:23.000000Z",
     *              "updated_at": "2023-09-26T13:14:23.000000Z"
     *      }
     *  }
     *
     * @param StoreContactRequest $request
     * @param int $id
     * @return ContactResource
     */
    public function update(StoreContactRequest $request,$id)
    {
        if(!$this->permissionCheck('update',\request()->user())){
            return new PermissionIssueResource(\request());
        }
        try{

            $contact = tap(Contact::findOrFail($id), function($contact) use ($request){
                $contact->country_code = $request['country_code'];
                $contact->number = $request['number'];
                $contact->active =  $request['opt_in'] ?? false;
                $contact->save();
            });
            return new ContactResource($contact);


        }catch (\Throwable $throwable){

            return  new  ErrorResource($throwable);

        }

    }

    /**
     * Delete Contact
     *
     * Remove a specific from the current department. Token Permissions may prevent this from working.
     *
     * @param StoreContactRequest $request
     * @authenticated
     * @group Contacts
     * @pathParam id integer required
     *  The id of the contact required
     *
     * @response {
     *       "status": 200,
     *        "message": "contact removed"
     *
     *  }
     *
     **/

    public function destroy($id)
    {
        header('');
        if(!$this->permissionCheck('delete',\request()->user())){
            return new PermissionIssueResource(\request());
        }
            try{
              Contact::findOrFail($id)->delete();
                return response()->json(['status'=>200,'message'=>'contact removed']);

            }catch (\Throwable $throwable){
                 return  new  ErrorResource($throwable);

            }
    }


}
