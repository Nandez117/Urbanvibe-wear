<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * User Attributes
 * $this->attributes['id'] - int - contains the user primary key (id)
 * $this->attributes['name'] - string - contains the user name
 * $this->attributes['email'] - string - contains the user email
 * $this->attributes['email_verified_at'] - datetime - contains the user email verification date
 * $this->attributes['password'] - string - contains the user password
 * $this->attributes['phone'] - string - contains the user phone number
 * $this->attributes['address'] - string - contains the user address
 * $this->attributes['role'] - string - contains the user role (admin, client)
 * $this->attributes['remember_token'] - string - contains the remember token
 * $this->attributes['created_at'] - datetime - contains the creation timestamp
 * $this->attributes['updated_at'] - datetime - contains the update timestamp
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Getters and Setters

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getEmail(): string
    {
        return $this->attributes['email'];
    }

    public function setEmail(string $email): void
    {
        $this->attributes['email'] = $email;
    }

    public function getPassword(): string
    {
        return $this->attributes['password'];
    }

    public function setPassword(string $password): void
    {
        $this->attributes['password'] = $password;
    }

    public function getPhone(): ?string
    {
        return $this->attributes['phone'] ?? null;
    }

    public function setPhone(?string $phone): void
    {
        $this->attributes['phone'] = $phone;
    }

    public function getAddress(): ?string
    {
        return $this->attributes['address'] ?? null;
    }

    public function setAddress(?string $address): void
    {
        $this->attributes['address'] = $address;
    }

    public function getRole(): string
    {
        return $this->attributes['role'];
    }

    public function setRole(string $role): void
    {
        $this->attributes['role'] = $role;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }
}
