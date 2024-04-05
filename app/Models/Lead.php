<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
   protected $table='lead';
    
    protected $fillable = [
        'Date',
        'Branch',
        'ResourceID',
        'CompanyName',
        'ContactPerson',
        'MobileNumber',
        'MailId',
        'Address',
        'PinCode',
        'Product',
        'Service',
        'NextFollowUpDate',
        'Remarks',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
