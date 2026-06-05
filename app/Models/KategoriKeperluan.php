<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriKeperluan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kategori_keperluans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_kategori',
    ];

    /**
     * Get the guests associated with the category.
     */
    public function tamus(): HasMany
    {
        return $this->hasMany(Tamu::class, 'kategori_id');
    }
}
