<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
    /**
     * [$guarded description]
     * @var array
     */
    protected $guarded = [];

    /**
     * [$hidden description]
     * @var [type]
     */
    protected $hidden = [
        'created_at','updated_at','jawaban_peserta'
    ];

    /**
     * [$casts description]
     * @var [type]
     */
    protected $casts = [
        'jawaban_peserta' => 'array'
    ];

    /**
     * [peserta description]
     * @return [type] [description]
     */
    public function peserta() 
    {
        return $this->hasOne(Peserta::class, 'id', 'peserta_id');
    }

    public function jawabans()
    {
        return $this->hasMany(JawabanPeserta::class,'id');
    }
}
