<?php


namespace App\Traits;

use App\Models\Role;

trait HasRoles
{

    // user , role => many to many
    // admin , role => many to many
    public function roles()
    {
        return $this->morphToMany(Role::class, 'authorizable', 'role_user');
    }

    public function hasAbility($ability)
    {
        //abilities =>  relation in role

        $denied =  $this->roles()->whereHas('abilities', function ($query) use ($ability) {
            $query->where('ability', $ability)
                ->where('type', 'deny');
        })->exists();

        if($denied){
            return false;
        }

        return $this->roles()->whereHas('abilities', function ($query) use ($ability) {
            $query->where('ability', $ability)
                ->where('type', 'allow');
        })->exists();
    }
}
