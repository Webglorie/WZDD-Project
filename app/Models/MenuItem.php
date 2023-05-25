<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MenuItem
 *
 * @property $id
 * @property $name
 * @property $url
 * @property $parent_id
 * @property $created_at
 * @property $updated_at
 *
 * @property MenuItem $menuItem
 * @property MenuItem[] $menuItems
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class MenuItem extends Model
{

    static $rules = [
		'name' => 'required',
		'url' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','url','parent_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function menuItem()
    {
        return $this->hasOne('App\Models\MenuItem', 'id', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuItems()
    {
        return $this->hasMany('App\Models\MenuItem', 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

    public static function getNestedMenuItems($parentId = null)
    {
        $menuItems = MenuItem::where('parent_id', $parentId)
            ->orderBy('order')
            ->get();

        $nestedMenu = [];

        foreach ($menuItems as $menuItem) {
            $children = MenuItem::getNestedMenuItems($menuItem->id);

            if ($children->isNotEmpty()) {
                $menuItem->children = $children;
            }

            $nestedMenu[] = $menuItem;
        }

        return collect($nestedMenu);
    }



}
