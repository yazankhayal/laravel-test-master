<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactAddress extends Model
{

    protected $table = 'contacts_address';

    protected $fillable = [
        'post_code',
        'contacts_id',
        'created_at', 'updated_at'
    ];

    public function Contact()
    {
        return $this->belongsTo(Contact::class,"contacts_id","id");
    }
}
