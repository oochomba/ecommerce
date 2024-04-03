<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductModel;
use App\Models\SubSubCategoryModel;

class SubCategoryModel extends Model
{
    use HasFactory;
    protected $table = 'sub_category';
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
        'category_id',
    ];

    public function getSubCategorySubCategories()
    {
        return $this->hasMany(SubSubCategoryModel::class, 'sub_category_id')->where(['sub_subCategory.status' => 0, 'sub_subCategory.is_delete' => 0])->orderBy('name', 'asc');
    }
  
    public function getProductCount()
    {
        return $this->hasMany(ProductModel::class, 'sub_category_id')
            ->where(['is_delete' => 0, 'status' => 0])
            ->count();
    }
}
