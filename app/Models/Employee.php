<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = '_employee';

    protected $fillable = [
        'zone', 'state', 'division', 'TerrCode', 'TerrName', 'EMPCODE', 'POSCODE', 'STATUS',
        'EMPNAME', 'DOJ', 'BIRTHDATE', 'DESIGNATION', 'DesignMIS', 'HEADQ', 'EmailJbpharma',
        'EMAILIDPERSONAL', 'MOBILENO', 'AMTerrCode', 'AMEmpCode', 'AMName', 'AMHQ', 'AMEmail',
        'RMTerrCode', 'RMEmpCode', 'RMName', 'RMHQ', 'RMEmailID', 'DSMTerrCode', 'DSMEmpCode',
        'DSMName', 'DSMHQ', 'DSMEmail', 'SMTerrCode', 'SMEmpCode', 'SMName', 'SMHQ', 'SMEmail',
    ];
}
