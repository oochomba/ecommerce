<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubCategoryModel;

class CategoryModel extends Model
{
    use HasFactory;
    protected $table = 'category';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'status',
        'is_delete',
        'created_by',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * get sub categories
     */
    static public function getCategories()
    {
        return self::select('category.*')
            ->where(['category.is_delete' => 0, 'category.status' => 0])
            ->orderBy('name', 'asc')
            ->get();
    }
    public function getCategorySubCategories()
    {
        return $this->hasMany(SubCategoryModel::class, 'category_id')->where(['sub_category.status' => 0, 'sub_category.is_delete' => 0])->orderBy('name', 'asc');
    }   
}
