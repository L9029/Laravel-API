<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id',
    ];

    /**
     * Define la relación entre Post y User.
     * Un post pertenece a un usuario.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accesors

    /**
     * Obtiene un resumen del contenido del post.
     * 
     * @return string
     */
    public function getExcerptAttribute(): string
    {
        // Retorna los primeros 60 caracteres del contenido del post
        return substr($this->content, 0, 60) . '...';
    }

    /**
     * Obtiene la fecha de creación del post formateada.
     * 
     * @return string
     */
    public function getPublishedAtAttribute(): string
    {
        // Formatea la fecha de creación del post
        return $this->created_at->format('d/m/Y');
    }
}
