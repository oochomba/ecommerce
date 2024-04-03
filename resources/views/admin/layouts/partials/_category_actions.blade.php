     @if (Auth::guard('admin')->user()->can('category.create'))
         <a href="{{ url('admin/category/list') }}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i>
             Category</a>
     @endif
     @if (Auth::guard('admin')->user()->can('subCategory.create'))
         <a href="{{ url('admin/sub_category/add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Sub
             Category</a>
     @endif
    
