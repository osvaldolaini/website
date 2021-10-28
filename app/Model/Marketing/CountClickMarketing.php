<?php

namespace App\Model\Marketing;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class CountClickMarketing extends Model
{
    use LogsActivity;

    protected $table = 'count_click_marketings';
    protected static $logAttributes = ['*'];
    /* set--Nomedainput--Attribute
     respeitando o case-sensitive
    */
    protected $fillable = [
        'marketing_id', 'marketing_table'
    ];
}
 