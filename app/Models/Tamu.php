<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tamu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tamus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'nomor_hp',
        'alamat',
        'kategori_id',
    ];

    /**
     * Get the category of the visitor purpose.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriKeperluan::class, 'kategori_id');
    }
}
