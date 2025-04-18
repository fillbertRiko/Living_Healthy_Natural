<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    // Mass assignable attributes
    protected $fillable = [
        // User information
        'user_id',
        'full_name',
        'email',
        'phone',
        'address',

        // Loyalty and membership
        'loyalty_card_number',
        'loyalty_points',
        'membership_level',

        // Personal details
        'date_of_birth',
        'gender',
        'status',
        'customer_type',

        // Referral and preferences
        'referral_code',
        'referral_source',
        'preferred_contact_method',
        'preferred_language',
        'preferred_currency',

        // Additional information
        'notes',
        'profile_picture',
        'social_media_links',
    ];
}
