<?php

namespace App\Http\Livewire;

use Livewire\Component;

class QuillEditor extends Component
{
    public $message;
    public $length ;
    public $maxLength = 160;
    public $messagesToSave = [];

    public function render()
    {
        $this->characterCount();
        return view('livewire.quill-editor');
    }


    public function characterCount(){

       $this->length =  strlen($this->toSMSformat( $this->message));

       if($this->length > $this->maxLength) {
           $this->messagesToSave = str_split($this->toSMSformat($this->message), $this->maxLength);
       }else{
           $this->messagesToSave =[ $this->toSMSformat($this->message)];
       }
       $this->emit('messageUpdate',$this->messagesToSave);
    }

    private function toSMSformat($message){
        $options = array(
            'ignore_errors' => true,
            'drop_links'=>true
        );
       return \Soundasleep\Html2Text::convert($message, $options);
    }
}
