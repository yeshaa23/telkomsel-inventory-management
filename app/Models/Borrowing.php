<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = [
        'borrower_name',
        'borrow_date',
        'return_date',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(BorrowingDetail::class);
    }
}
