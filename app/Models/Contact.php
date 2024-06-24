<?php

namespace App\Models;

use App\Models\Scopes\HasTeamScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

class Contact extends Model
{
    use HasFactory;


    protected $fillable = [
        'title' ,
        'firstname' ,
        'lastname',
        'country_code',
        'number',
        'team_id' ,
        'active',
        'created_by',
        'optout_reason',
    ];


    protected $with = ['custom'];

    protected static function booted()
    {
        // using seperate scope class
        static::addGlobalScope(new HasTeamScope());
    }


    public function getFullNameAttribute() // notice that the attribute name is in CamelCase.
    {
        return $this->title . ' '.$this->firstname . ' ' . $this->lastname;
    }

    public function groups(){
        return $this->hasManyThrough(
            Group::class,
            ContactGroup::class,
            'contact_id', // Foreign key on the ContactGroup table...
            'id', // Foreign key on the Contacts table...
            'id', // Local key on the Group table...
            'group_id' // Local key on the ContactGroup table...
        );

    }

    public function groupRelation(){
        return $this->hasMany(ContactGroup::class,'contact_id','id');
    }

    public function createdByUser(){
        return $this->hasOne(User::class,'id','created_by');
    }

    /**
     * Get all of the custom data.
     */
    public function custom(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(CustomContactInfo::class, 'contactable');
    }
}
