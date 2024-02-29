<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comune extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'comunis';

    protected $dates = [];

    protected $fillable = [
        'codice_regione',
        'progressivo_del_comune',
        'codice_comune_formato_alfanumerico',
        'denominazione',
        'codice_ripartizione_geografica',
        'ripartizione_geografica',
        'denominazione_regionale',
        'denominazione_unita_territoriale_sovracomunale',
        'sigla_automobilistica',
        'codice_comune_formato_numerico',
        'codice_catastale_del_comune',
        'cap',
        'prefisso',
        'codfisco'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
