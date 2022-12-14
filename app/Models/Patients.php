<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'address', 'status_patient_id', 'in_date_at', 'out_date_at'];

    protected $hidden = ['status_patient_id', 'created_at', 'updated_at'];

    public function statusPatient()
    {
        return $this->belongsTo(StatusPatient::class);
    }
}
