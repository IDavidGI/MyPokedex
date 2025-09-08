<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoundPokemon extends Model
{
    protected $fillable = ['user_id', 'pokemon_name'];
}
