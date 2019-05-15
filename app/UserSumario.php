<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserSumario extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
}
