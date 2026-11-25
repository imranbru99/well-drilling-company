<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'job_number', 'customer_id', 'title', 'service_type', 'status', 'sq_ft',
        'quoted_amount', 'final_amount', 'start_date', 'end_date', 'site_address', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'sq_ft' => 'decimal:2',
            'quoted_amount' => 'decimal:2',
            'final_amount' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
