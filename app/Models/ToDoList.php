<?php


namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ToDoList extends Model
{

    /**
     * @var array
     */
    protected $guarded = [];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function itemsCount(): int
    {
        return $this->items()->get()->count();
    }
}
