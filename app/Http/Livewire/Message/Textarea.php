<?php

namespace App\Http\Livewire\Message;

use App\Http\Traits\UserDefinedVars;
use App\Models\MessageTemplate;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Textarea extends Component
{
    use LivewireAlert;
    public $name;
    public $message;
    public $messageHTML;
    public $messageAfterVars;
    public $messagesToSave;
    public $length=0;
    public $maxLength = 160;

    public $variables = [];

    public $contactVariables = [];

    protected $listeners = ['templateSelected'=> 'updateTextarea'];
    use UserDefinedVars;

    public function mount ()
    {


        $this->contactVariables =  $this->userVars();
        $this->characterCount();
        $this->message = '';

    }

    public function render()
    {
       $this->contactVariables =  $this->userVars();
        $this->characterCount();
        return view('livewire.message.textarea',[
            'count'=>$this->length
        ]);
    }

    public function characterCount(){

        $brAdded=  nl2br($this->message);
        $this->messageHTML =  $this->toSMSformat($brAdded) ;

        $this->messageAfterVars = $this->message;

        foreach ($this->variables as $value){

            if($value['value'] && $value['placeholder']){
                $this->messageAfterVars =   str_replace($value['placeholder'], $value['value'],  $this->messageAfterVars);
            }

        }

           $this->length =  strlen($this->messageAfterVars);

        if($this->length > $this->maxLength) {
            $this->messagesToSave = str_split($this->toSMSformat( $this->messageAfterVars), $this->maxLength);
        }else{
            $this->messagesToSave =[ $this->toSMSformat( $this->messageAfterVars)];
        }
        $this->length > $this->maxLength ?  $this->emit('messageUpdate',str_split($this->messageHTML, $this->maxLength)):  $this->emit('messageUpdate',[$this->messageHTML]);


    }

    private function toSMSformat($message){
        $options = array(
            'ignore_errors' => true,
            'drop_links'=>true
        );


       return \Soundasleep\Html2Text::convert($message, $options);
    }

    public function addVariable(){
        $new = [
            'placeholder'=>'[VariableName]',
            'value'=>null,
        ];
        array_push($this->variables ,$new);
    }

    public function updateTextarea($template){

        $this->message =$template['text'];
        $this->variables =$template['vars'];
    }

    public function saveTemplate(){

        $this->validate([
           'name'=>'required|min:4',
           'messagesToSave.message'=>'array:0'
        ]);


        MessageTemplate::create([
           'name'=>$this->name,
           'message'=>$this->message,
           'variables'=>json_encode([
               'template'=>  $this->variables,
               'global'=>   $this->contactVariables
           ]),
            'team_id'=>Auth::user()->currentTeam->id,
            'company_id'=>Auth::user()->currentTeam->company->id,
            'characters'=>$this->length,
            'message_count'=>count($this->messagesToSave)
        ]);
        $this->message = null;
        $this->name = null;
        $this->alert('success', 'Template Saved');
        $this->emit('userTemplateSaved');
    }

    public function addBreak(){
//        $this->message = $this->message. "\r\n";
        $this->messageHTML = $this->messageHTML."</p>";

    }

}
