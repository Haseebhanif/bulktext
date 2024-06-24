<?php

namespace App\Http\Livewire\Contact;


use App\Imports\ContactImport;
use App\Jobs\ContactsToImport;
use App\Jobs\TestImport;
use App\Models\EmailService;
use App\Models\Group;
use App\Models\ImportReview;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Livewire\Component;
use Excel;
use Livewire\WithPagination;
use Illuminate\Support\Collection;

class ImportForm extends Component
{

    use WithPagination;
    use LivewireAlert;
    use WithFileUploads;

    public $filename;
    public $testFile;

    public $importGroup;

    public $selectedGroup;

    public  $createNewGroup = false;
    public $newGroupName;

    public $importStatus = false;
    public $hasRecord = false;
    public $importFile = null;
    public $toImportErrors = [];
    public $importCount = 0;
    public $failureErrorsCount = 0;
    public $toImport = 0;

    public $perPage = 500;


    public $loadcount  =0;

    protected $listeners = ['newGroup'=>'submit' ,'refresh'=>'$refresh'];

    protected $messages = [
        'filename.required' => 'A contacts file is required to for upload.',
        'filename.mimes:xlsx' => 'The file type must me a xlsx format.',
    ];

    public function mount(){
       $group = Group::query();
            $this->importGroup = $group->first()->id;
            $this->selectedGroup = $group->first()->id;

        $importReview = ImportReview::query();
        $hasErrors =  $importReview->where('team_id',Auth::user()->currentTeam->id)->first();

        if($hasErrors and $hasErrors->complete){
            $arrayData = json_decode($hasErrors->errors, true) ?? [];
            $collection = collect($arrayData);


            $this->hasRecord = (bool) $hasErrors;
            $this->importStatus = true;
            // We paginate the collection directly

            $this->toImportErrors =   $this->paginateCollection($collection);
            $this->failureErrorsCount = $hasErrors->error_count;
            $this->importCount = $hasErrors->success_count;
        }else{
            $this->importStatus = false;
            $this->hasRecord = (bool)$hasErrors;

           // $this->importFile = $hasErrors->file_name;
        }

    }

    public function import()
    {

        $this->validate([
            'filename' => 'required|mimes:xlsx|max:10240', // 10MB Max
            'importGroup' => 'required', // group
        ]);

       $location = $this->filename->store('imports/'.Auth::user()->email.'/'.$this->importGroup);

        $this->loadcount++;
        $user =  Auth::user();
        $teamId =  $user->currentTeam->id;

        $importReview = ImportReview::query();
        $hasValue = $importReview->where('team_id',Auth::user()->currentTeam->id)->first();

        $emailService = EmailService::where('tenant_id',$user->tenant_id)->first();


        $email =$emailService ? $emailService->email :   env('MAIL_FROM_ADDRESS');


        // The "users" table exists...
        $branding = Tenant::select('logo', 'login', 'register', 'colour1', 'colour2', 'tenant_name', 'domain')->find($user->tenant_id);
        if(!$hasValue){

            ContactsToImport::dispatch($teamId,$this->importGroup,$location,$user->id,$email);



            $newImport = new ImportReview();
            $newImport->complete = false;
            $newImport->file_name =$location;
            $newImport->team_id = $teamId;
            $newImport->success_count = 0;
            $newImport->error_count = 0;
            $newImport->save();

            $this->alert('success', 'contacts queued for import');
            $this->importStatus = false;
            $this->hasRecord = true;
            $this->emit('stats');

        }elseif($hasValue and $hasValue->complete){
            $hasValue->complete = false;
            $hasValue->file_name =$location;
            $hasValue->team_id = $teamId;
            $hasValue->success_count = 0;
            $hasValue->error_count = 0;
            $hasValue->save();

            ContactsToImport::dispatch($teamId,$this->importGroup,$location,$user->id,$email);
            $this->alert('success', 'contacts queued for import');
            $this->importStatus = false;
            $this->emit('stats');
        }else{
            $this->alert('warning', ' Contacts import in progress. please try again once import is complete.');
        }
        \Log::info("Dispatching job with data: Team ID: $teamId, Import Group:  $this->importGroup, Location: $location, User ID:  $user->id, Email: $email, Branding: " . print_r($branding, true));

    }

    public function clearImport(){
        $this->toImportErrors = [];
        $this->toImport = 0;
        $this->importCount = 0;
    }

    /**
     *Creates a new Contact Group
     */
    public function submit()
    {

        $this->validate(
            [     'newGroupName' => 'required|min:3']
        );


            $group = Group::create([
                'name' => ucfirst($this->newGroupName),
                'team_id' => Auth::user()->currentTeam->id
            ]);

            $this->importGroup = $group->id;
            $this->selectedGroup = $group->id;
            $this->createNewGroup = false;
            $this->emit('stats');

    }

    public function render()
    {
        return view('livewire.contact.import-form',[
            'groups'=>Group::get(),
            'failureErrors'=>$this->toImportErrors
        ]);
    }





    /**
     * Custom pagination handling for collections in Livewire.
     *
     * @param Collection $collection
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    /**
     * Paginate any collection.
     *
     * @param Collection $collection The collection to paginate.
     * @return array
     */
        public function paginateCollection(Collection $collection)
    {
        $page = Paginator::resolveCurrentPage();
        $total = $collection->count();
        $results = $collection->forPage($page, $this->perPage)->values();

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $results,
            $total,
            $this->perPage,
            $page,
            [
                'path' => Paginator::resolveCurrentPath(),
                'query' => request()->query(),
            ]
        );



        // Only return the data as an array
        return $paginator->items();
    }



    public function downloadErrors (){


        $importReview = ImportReview::query();
        $hasErrors =  $importReview->where('team_id',Auth::user()->currentTeam->id)->first();

        if($hasErrors and $hasErrors->complete) {
            $arrayData =$hasErrors->errors;

          $removesBrackets =   str_replace(['{','[',']'],'',$arrayData);
          $data =  str_replace(['}}'],'--row-end--',$removesBrackets);
            return response()->streamDownload(function () use ($data) {
                echo $data;
            }, 'error-export.txt');



        }

    }



}
