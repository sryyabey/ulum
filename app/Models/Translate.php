<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Translate extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'translates';

    public static $searchable = [
        'translate',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'lang_id',
        'ayah',
        'translate',
        'surah_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function lang()
    {
        return $this->belongsTo(Language::class, 'lang_id');
    }

    public function surah()
    {
        return $this->belongsTo(Surah::class, 'surah_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
