<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductColorModel;
use App\Models\ProductSizeModel;
use App\Models\ProductImageModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Request;

class ProductModel extends Model
{
    use HasFactory;
    protected $table = 'product';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'status',
        'is_delete',
        'created_by',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'tag',
    ];

    static public function getSingle($id)
    {
        return self::find($id);
    }

    public function getColor()
    {
        return $this->hasMany(ProductColorModel::class, 'product_id');
    }

    public function getSize()
    {
        return $this->hasMany(ProductSizeModel::class, 'product_id');
    }
    public function getImage()
    {
        return $this->hasMany(ProductImageModel::class, 'product_id')->orderBy('order_by', 'asc');
    }

    public function getImageSingle($product_id)
    {
        return ProductImageModel::where('product_id', $product_id)->orderBy('order_by', 'asc')->first();
    }

    static public function getRelatedProducts($id, $sub_category_id)
    {
        $return = ProductModel::select('product.*', 'category.name as category_name', 'category.slug as category_slug', 'sub_category.name as sub_category_name', 'sub_category.slug as sub_category_slug')
            ->join('category', 'category.id', '=', 'product.category_id')
            ->join('sub_category', 'sub_category.id', '=', 'product.sub_category_id')
            ->where(['product.is_delete' => 0, 'product.status' => 0, 'product.sub_category_id' => $sub_category_id])
            ->where('product.id', '!=', $id)
            ->groupBy('product.id')
            ->orderBy("product.id", "desc")
            ->limit(12)
            ->get();
        return $return;
    }

    static public function getSingleSlug($slug)
    {
        return self::where(['slug' => $slug, 'status' => 0, 'is_delete' => 0])->first();
    }
    public function getCategory()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }
    public function getSubCategory()
    {
        return $this->belongsTo(SubCategoryModel::class, 'sub_category_id');
    }

    public function getSubSubCategory()
    {
        return $this->belongsTo(SubSubCategoryModel::class, 'category_id');
    }

    static public function getProduct($category_id = '', $sub_category_id = '')
    {
        $return = ProductModel::select('product.*', 'category.name as category_name', 'category.slug as category_slug', 'sub_category.name as sub_category_name', 'sub_category.slug as sub_category_slug')
            ->join('category', 'category.id', '=', 'product.category_id')
            ->join('sub_category', 'sub_category.id', '=', 'product.sub_category_id');
        if (!empty($category_id)) {
            $return = $return->where(['product.category_id' => $category_id]);
        }
        if (!empty($sub_category_id)) {
            $return = $return->where(['product.sub_category_id' => $sub_category_id]);
        }

        if (!empty(Request::get('sub_category_id'))) {
            $sub_category_id = rtrim(Request::get('sub_category_id'), ',');
            $sub_category_array = explode(',', $sub_category_id);
            $return = $return->whereIn('product.sub_category_id', $sub_category_array);
        } else {
            if (!empty(Request::get('old_category_id'))) {
                $return = $return->where(['product.category_id' => Request::get('old_category_id')]);
            }
            if (!empty(Request::get('old_sub_category_id'))) {
                $return = $return->where(['product.sub_category_id' => Request::get('old_sub_category_id')]);
            }
        }




        if (!empty(Request::get('color_id'))) {
            $color_id = rtrim(Request::get('color_id'), ',');
            $color_id_array = explode(',', $color_id);
            $return = $return->join('product_color', 'product_color.product_id', '=', 'product.id');
            $return = $return->whereIn('product_color.color_id', $color_id_array);
        }

        if (!empty(Request::get('brand_id'))) {
            $brand_id = rtrim(Request::get('brand_id'), ',');
            $brand_id_array = explode(',', $brand_id);
            $return = $return->whereIn('product.brand_id', $brand_id_array);
        }

        if (!empty(Request::get('start_price'))) {
            // $start_price = str_replace('KES', '', Request::get('start_price'));
            $start_price = Request::get('start_price');
            $return = $return->where('product.price', '>=', $start_price);
        }

        if (!empty(Request::get('end_price'))) {
            //  $end_price = str_replace('KES', '', Request::get('end_price'));
            $end_price = Request::get('end_price');
            $return = $return->where('product.price', '<=', $end_price);
        }

        if (!empty(Request::get('q'))) {
            $return = $return->where('product.title', 'like', '%' . Request::get('q') . '%');
        }
        if (!empty(Request::get('sort_by_id'))) {
            if (Request::get('sort_by_id') == 'date') {
                $return = $return->orderBy('created_at', 'desc');
            }
        }



        $return = $return->where(['product.is_delete' => 0, 'product.status' => 0])
            ->groupBy('product.id')
            ->orderBy("product.id", "desc")
            ->paginate(16);
        return $return;
    }
}
