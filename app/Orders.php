<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{

    protected $table = 'orders';

    protected $fillable = [
        'name',
        'price',
        'text',
        'companies_id',
        'created_at', 'updated_at'
    ];

    public function Company()
    {
        return $this->belongsTo(Company::class,"companies_id","id");
    }
}
