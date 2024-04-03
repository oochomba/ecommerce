<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubCategoryModel;

class SubSubCategoryModel extends Model
{
    use HasFactory;
    protected $table = 'sub_subCategory';
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
        'sub_category_id',
        'category_id'
    ];

    public function getProductCount()
    {
        return $this->hasMany(SubCategoryModel::class, 'sub_subcategory_id')
            ->where(['is_delete' => 0, 'status' => 0])
            ->count();
    }

    public function getCategory()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }
    public function getSubCategory()
    {
        return $this->belongsTo(SubCategoryModel::class, 'sub_category_id');
    }
    public function getSubSubCategory(){
        return $this->belongsTo(SubSubCategoryModel::class, 'subcategory_id');
    }

}
