<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'status',
    ];

    protected $appends = [
        'status_label',
        'full_name',
        'partial_name'
    ];


    public function accounts()
    {
        return $this->hasMany(\App\Models\Account::class)->where('account_status', 'open');
    }


    public function score()
    {
        return $this->hasOne(\App\Models\Score::class);
    }

    public function getStatusLabelAttribute()
    {
        switch($this->status){
            case 'active':
                return 'Active';
            case 'partial':
                return 'Partial Data Match';
            case 'failed':
                return 'Failed ID';
        }
    }


    public function getFullNameAttribute()
    {
        return sprintf('%s %s %s', $this->first_name, $this->middle_name, $this->last_name);
    }

    public function getPartialNameAttribute()
    {
        return sprintf('%s %s', $this->first_name, $this->last_name);
    }


}
