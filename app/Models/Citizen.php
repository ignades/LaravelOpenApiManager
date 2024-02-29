<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    use HasFactory;

    protected $table = 'citizens';

    protected $fillable = [
        'first_name','last_name','sex','data_nascita',
        'cf','ragione_sociale','piva','pec','email','web_site','phone','mobile_number',
        'age','status_id',
        'address','comune','cap','provincia','nazione','regione',
        'latitudine','longitudine','user_id','note', 'project_id'
    ];

}
