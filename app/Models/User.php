<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Zorb\Promocodes\Traits\AppliesPromocode;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable; 
    use HasRoles; 
    use AppliesPromocode;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'job_role',
        'company',
        'website',
        'email',
        'workbook',
        'password',
        'phone_number',
        'address',
        'city',
        'postal_code',
        'plan_type',
        'country',
        'profile_photo_path',
        'oauth_id',
        'oauth_type',
        'last_seen',
        'referral_id',
        'referred_by',
        'referral_payment_method',
        'referral_paypal',
        'referral_bank_requisites',
        'default_template_language',
        'default_voiceover_language',
        'default_voiceover_voice',
        'member_of',
        'member_limit',
        'member_use_credits_template',
        'member_use_credits_chat',
        'member_use_credits_code',
        'member_use_credits_voiceover',
        'member_use_credits_speech',
        'member_use_credits_image',
        'personal_openai_key',
        'personal_claude_key',
        'personal_gemini_key',
        'personal_sd_key',
        'hidden_plan',
        'used_free_tier',
        'theme',
        'plagiarism_pages',
        'ai_detector_pages',
        'subscription_required',
        'verification_code',
        'email_opt_in',
        'default_model_template',
        'default_model_chat',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'available_words',
        'available_words_prepaid',
        'total_words',
        'available_images',
        'available_images_prepaid',
        'total_images',
        'group',
        'plan_id',
        'status',
        'balance',
        'google2fa_enabled',
        'google2fa_secret',
        'available_chars',
        'available_chars_prepaid',
        'available_minutes',
        'available_minutes_prepaid',
        'total_chars',
        'total_minutes',
        'total_dalle_images',
        'available_dalle_images',
        'available_dalle_images_prepaid',
        'total_sd_images',
        'available_sd_images',
        'available_sd_images_prepaid',
        'gpt_3_turbo_credits',
        'gpt_4_turbo_credits',
        'gpt_4_credits',
        'gpt_4o_credits',
        'claude_3_opus_credits',
        'claude_3_sonnet_credits',
        'claude_3_haiku_credits',
        'fine_tune_credits',
        'gpt_3_turbo_credits_prepaid',
        'gpt_4_turbo_credits_prepaid',
        'gpt_4_credits_prepaid',
        'gpt_4o_credits_prepaid',
        'claude_3_opus_credits_prepaid',
        'claude_3_sonnet_credits_prepaid',
        'claude_3_haiku_credits_prepaid',
        'fine_tune_credits_prepaid',
        'gemini_pro_credits',
        'gemini_pro_credits_prepaid',
        'gpt_4o_mini_credits',
        'gpt_4o_mini_credits_prepaid',
        'o1_preview_credits',
        'o1_mini_credits',
        'o1_preview_credits_prepaid',
        'o1_mini_credits_prepaid',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function path()
    {
        return route('admin.users.show', $this);
    }

    /**
     * User can have many support tickets
     */
    public function support()
    {
        return $this->hasMany(SupportTicket::class);
    }

    /**
     * User can have many payments
     */
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

    public function subscriber()
    {
        return $this->hasOne(Subscriber::class);
    }


    public function hasActiveSubscription()
    {
        return optional($this->subscriber)->isActive($this->id) ?? false;
    }

}
