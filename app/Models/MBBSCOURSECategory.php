<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MBBSCOURSECategory extends Model
{
    use HasFactory;

    protected $table = 'mbbs_course_categories';

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'description',
        'order',
        'is_active'
    ];

    /**
     * Get the parent category
     */
    public function parent()
    {
        return $this->belongsTo(MBBSCOURSECategory::class, 'parent_id');
    }

    /**
     * Get all child categories
     */
    public function children()
    {
        return $this->hasMany(MBBSCOURSECategory::class, 'parent_id')->orderBy('order', 'asc');
    }

    /**
     * Get all active child categories
     */
    public function activeChildren()
    {
        return $this->hasMany(MBBSCOURSECategory::class, 'parent_id')
            ->where('is_active', 1)
            ->orderBy('order', 'asc');
    }

    /**
     * Check if category has children
     */
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    /**
     * Get the depth level of the category
     */
    public function getLevelAttribute()
    {
        $level = 0;
        $parent = $this->parent;
        while ($parent) {
            $level++;
            $parent = $parent->parent;
        }
        return $level;
    }

    /**
     * Get root categories (categories without parent)
     */
    public static function getRootCategories()
    {
        return self::whereNull('parent_id')->orderBy('order', 'asc')->get();
    }

    /**
     * Get all categories in tree structure
     */
    public static function getTree()
    {
        return self::with('children')->whereNull('parent_id')->orderBy('order', 'asc')->get();
    }
}

