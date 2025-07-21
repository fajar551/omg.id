<?php

namespace App\Models;

use App\Notifications\DisbursementNotification;
use App\Notifications\EmailVerificationNotification;
use App\Notifications\NewTipNotification;
use App\Notifications\PayoutAccountActivationNotification;
use App\Notifications\PayoutAccountVerifiedNotification;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\WelcomeEmailNotification;
use App\Src\Base\Notifiable;
use App\Src\Helpers\Constant;
// use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use ESolution\DBEncryption\Traits\EncryptedAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, EncryptedAttribute, LogsActivity;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'must_change_password',
        'provider_id',
        'provider',
        'gender',
        'profile_picture',
        'status', 
        'address',
        'address_city',
        'address_province',
        'address_district',
        'welcome_email_send_at'
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
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_picture_path',
    ];

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
     * Check if column is required to encripted.
     * 
     * @return bool
     */
    public function isColumnEncripted($column)
    {
        return in_array($column, $this->encryptable);
    }

    /**
     * The accessors to get profile with full path.
     *
     * @param string|null $value
     * @return string
     */
    public function getProfilePicturePathAttribute($value)
    {
        return $this->profile_picture
                ? route("api.profile.preview", ["file_name" => $this->profile_picture ?: Constant::UNKNOWN_STATUS]) 
                : asset("template/images/user/user.png");
    }

    /**
     * Get the model relation to comments.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, "user_id", "id");
    }

    /**
     * Get the model relation to post.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function post()
    {
        return $this->hasMany(Post::class, "user_id", "id");
    }

    /**
     * Get the model relation to content.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function content()
    {
        return $this->hasMany(Content::class);
    }

    /**
     * Get the model relation to goal.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goal()
    {
        return $this->hasMany(Goal::class, "user_id", "id");
    }

    /**
     * Send notificiation for password reset.
     * 
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $params = [
            "userid" => $this->id,
            "name" => $this->name,
            "username" => $this->username,
            "email" => $this->email,
            "url" => route($this->hasRole(['admin']) ? "admin.password.reset" : "password.reset", ["token" => $token, 'email' => $this->email]),
        ];

        try {
            $this->notify(new ResetPasswordNotification($params));
        } catch (\Throwable $ex) {
            activity()
                ->inLog('sendPasswordResetNotification')
                ->performedOn($this)
                ->causedBy($this)
                ->withProperties(['attributes' => [
                    "class" => User::class,
                    "function" => 'sendPasswordResetNotification',
                    "error" => $ex->getCode(),
                    "message" => $ex->getMessage(),
                    "trace" => strtok($ex->getTraceAsString(), '#1')
                ]])
                ->log($ex->getMessage());
        }
    }

    /**
     * Send notificiation for email verification.
     * 
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $params = [
            "userid" => $this->id,
            "name" => $this->name,
            "username" => $this->username,
            "email" => $this->email,
        ];

        try {
            $this->notify(new EmailVerificationNotification($params));
        } catch (\Throwable $ex) {
            activity()
                ->inLog('sendEmailVerificationNotification')
                ->performedOn($this)
                ->causedBy($this)
                ->withProperties(['attributes' => [
                    "class" => User::class,
                    "function" => 'sendEmailVerificationNotification',
                    "error" => $ex->getCode(),
                    "message" => $ex->getMessage(),
                    "trace" => strtok($ex->getTraceAsString(), '#1')
                ]])
                ->log($ex->getMessage());
        }
    }

    /**
     * Send notificiation for new registered user.
     * 
     * @return void
     */
    public function sendWelcomeEmailNotification()
    {
        if ($this->welcome_email_send_at) {
            return false;
        }
        $params = [
            "userid" => $this->id,
            "name" => $this->name,
            "username" => $this->username,
            "email" => $this->email,
        ];

        try {
            $this->welcome_email_send_at = now();
            $this->save();
            $this->notify(new WelcomeEmailNotification($params));
        } catch (\Throwable $ex) {
            activity()
                ->inLog('sendWelcomeEmailNotification')
                ->performedOn($this)
                ->causedBy($this)
                ->withProperties(['attributes' => [
                    "class" => User::class,
                    "function" => 'sendWelcomeEmailNotification',
                    "error" => $ex->getCode(),
                    "message" => $ex->getMessage(),
                    "trace" => strtok($ex->getTraceAsString(), '#1')
                ]])
                ->log($ex->getMessage());
        }
    }

    /**
     * Send notificiation for new tip received.
     * 
     * @param array $params
     * @return void
     */
    public function sendNewTipNotification($params)
    {
        $this->notify(new NewTipNotification($params));
    }

    /**
     * Send notificiation for payout account activation.
     * 
     * @param array $params
     * @return void
     */
    public function sendPayoutAccountActivationNotification($params)
    {
        $this->notify(new PayoutAccountActivationNotification($params));
    }

    /**
     * Send notificiation for payout account has verified.
     * 
     * @param array $params
     * @return void
     */
    public function sendPayoutAccountVerifiedNotification($params)
    {
        $this->notify(new PayoutAccountVerifiedNotification($params));
    }

    /**
     * Send notificiation for new disbursement.
     * 
     * @param array $params
     * @return void
     */
    public function sendDisbursementNotification($params)
    {
        $this->notify(new DisbursementNotification($params));
    }
    
    /**
     * Get the model relation to widgets.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function widgets()
    {
        return $this->belongsToMany(Widget::class, "user_widgets", "user_id", "widget_id")->withTimestamps();
    }

    /**
     * Get the model relation to streamKey.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function streamKey()
    {
        return $this->hasOne(StreamKey::class);
    }

    /**
     * Get the model relation to page.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function page()
    {
        return $this->hasOne(Page::class);
    }

    /**
     * Get the model relation to socialLinks.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class);
    }

    /**
     * Get the model relation to payoutaccount.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payoutaccount()
    {
        return $this->hasMany(PayoutAccount::class);
    }
    
    /**
     * Get the model relation to balance.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function balance()
    {
        return $this->hasOne(UserBalance::class);
    }

    /**
     * Get the model relation to followers.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'followers_id');
    }

    /**
     * Get the model relation to followings.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'followers_id', 'user_id');
    }

    /**
     * Get the model relation to items.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Check if permission is selected.
     * 
     * @return bool
     */
    public function isPermissionIdSelected($permissionId)
    {
        return in_array($permissionId, $this->permissions->pluck('id')->toArray());
    }

    /**
     * Check if role is selected.
     * 
     * @return bool
     */
    public function isRoleIdSelected($roleId)
    {
        return in_array($roleId, $this->roles->pluck('id')->toArray());
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
