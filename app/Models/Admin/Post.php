<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;
  protected $fillable=[
      'title',
      'content',
      'image',
      'author_id'
  ];

  public function user():belongsTo
  {
      return $this->belongsTo(User::class);
  }
}
