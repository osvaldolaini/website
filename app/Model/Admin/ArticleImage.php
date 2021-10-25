<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
class ArticleImage extends Model
{
    use LogsActivity;
    protected $table = 'article_images';
    protected static $logAttributes = ['*'];
}
