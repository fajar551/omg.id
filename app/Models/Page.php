<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Page extends Model
{
    use HasFactory, EncryptedAttribute, LogsActivity;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime', 
        'updated_at' => 'datetime',
    ];

    /**
     * The logging attributes.
     *
     * @var string<string, string>
     * @var bool
     */
    protected static $logAttributes = ["*"];
    protected static $logFillable = true;
    
    /**
     * The attributes that should be encrypted on save.
     *
     * @var array
     */
    protected $encryptable = [];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);

        if (config('encrypt.enable')) {
            $this->encryptable = config("encrypt.table.{$this->table}");
        }
    }

    /**
     * Get the model relation to user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the model relation to category.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(PageCategory::class);
    }

    /**
     * Get the model relation to content.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function content()
    {
        return $this->hasManyThrough(Content::class, User::class, "id", "user_id", "user_id");
    }

    /**
     * Get activity log options.
     * 
     * @return \Spatie\Activitylog\LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
    
}
