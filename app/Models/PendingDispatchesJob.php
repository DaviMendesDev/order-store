<?php

namespace App\Models;

use App\Models\Utils\Model\FieldNullification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingDispatchesJob extends Model
{
    use HasFactory;
    use FieldNullification;

    public function order () {
        return $this->belongsTo(Order::class);
    }
}
