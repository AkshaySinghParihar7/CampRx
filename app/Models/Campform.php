<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campform extends Model
{
    use HasFactory;

    protected $fillable = [
        'tmName',
        'doctorName',
        'campType',
        'speciality',
        'POB',
        'noOfPatientScreened',
        'onOfRxnGenerated',
        'campDate',
        'POBImagePath',
        'empId'
    ];
}
