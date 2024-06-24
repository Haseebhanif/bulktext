<?php

namespace App\Models;

use App\Models\Scopes\HasTeamScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['team_id','name'];


    protected static function booted()
    {
        // using seperate scope class
        static::addGlobalScope(new HasTeamScope());
    }


    public function contacts(){

        return $this->hasManyThrough(
            Contact::class,
            ContactGroup::class,
            'group_id',
            'id',
            'id',
            'contact_id'
        );


    }


    public function activeContacts(){

        return $this->hasManyThrough(
            Contact::class,
            ContactGroup::class,
            'group_id',
            'id',
            'id',
            'contact_id'
        )->where('active','=',1);


    }


    public function contactsCount(){

        return $this->contacts()->count();


    }
}
