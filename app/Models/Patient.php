<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

/**
 * App\Models\Patient
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $date_of_birth
 * @property string|null $gender
 * @property string $email
 * @property string|null $phone
 * @property string|null $emergency_contact
 * @property string|null $address
 * @property string $username
 * @property string $password
 * @property string|null $medical_history
 * @property string|null $dental_concerns
 * @property string|null $profile_image
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $full_name
 */
class Patient extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'email',
        'phone',
        'emergency_contact',
        'address',
        'username',
        'password',
        'medical_history',
        'dental_concerns',
        'profile_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'full_name',
    ];

    /**
     * Automatically hash password when setting it
     */
    public function setPasswordAttribute(?string $value): void
    {
        if (!empty($value) && !Hash::needsRehash($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Get full name attribute
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * Use username as the authentication identifier
     */
    public function getAuthIdentifierName(): string
    {
        return 'username';
    }
}
