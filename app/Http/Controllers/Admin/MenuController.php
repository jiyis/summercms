<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\DataType;

class MenuController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $slug = $request->segment(2);

        // GET THE DataType based on the slug
        $model = new DataType();
        $dataType = $model->newQueryWithoutScopes()->where('slug', '=', $slug)->first();

        // Next Get the actual content from the MODEL that corresponds to the slug DataType
        $model_name = $dataType->model_name;
        $dataTypeContent = (strlen($model_name) != 0)
            ? call_user_func([$model_name::orderBy('updated_at', 'desc'), 'get'])
            : DB::table($dataType->name)->orderBy('updated_at', 'desc')->get(); // If Model doest exist, get data from table name
        $view = 'admin.bread.browse';

        if (view()->exists("admin.$slug.browse")) {
            $view = "admin.$slug.browse";
        } elseif (view()->exists("admin.$slug.browse")) {
            $view = "admin.$slug.browse";
        }
        return view($view, compact('dataType', 'dataTypeContent'));
    }

    //***************************************
    //                _____
    //               |  __ \
    //               | |__) |
    //               |  _  /
    //               | | \ \
    //               |_|  \_\
    //
    //  Read an item of our Data Type B(R)EAD
    //
    //****************************************

    public function show(Request $request, $id)
    {
        $slug = $request->segment(2);
        $model = new DataType();
        $dataType = $model->newQueryWithoutScopes()->where('slug', '=', $slug)->first();


        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? call_user_func([$dataType->model_name, 'find'], $id)
            : DB::table($dataType->name)->where('id', $id)->first(); // If Model doest exist, get data from table name

        return view('admin.bread.read', compact('dataType', 'dataTypeContent'));
    }

    //***************************************
    //                ______
    //               |  ____|
    //               | |__
    //               |  __|
    //               | |____
    //               |______|
    //
    //  Edit an item of our Data Type BR(E)AD
    //
    //****************************************

    public function edit(Request $request, $id)
    {
        $slug = $request->segment(2);
        $model = new DataType();
        $dataType = $model->newQueryWithoutScopes()->where('slug', '=', $slug)->first();

        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? call_user_func([$dataType->model_name, 'find'], $id)
            : DB::table($dataType->name)->where('id', $id)->first(); // If Model doest exist, get data from table name

        $view = 'admin.bread.edit-add';

        if (view()->exists("admin.$slug.edit-add")) {
            $view = "admin.$slug.edit-add";
        } elseif (view()->exists("admin.$slug.edit")) {
            $view = "admin.$slug.edit";
        }
        //获取所有栏目
        $model_name = DataType::where(['slug'=>$slug])->first()->name;
        $category = Category::where(['model' => $model_name])->get()->keyBy(function($item){return $item->id;})->map(function($value){
            return $value->title;
        })->toArray();
        //查询当前存在tags
        $etags = TagsData::where(['category_id' => $dataTypeContent->category_id, 'data_id' => $dataTypeContent->id])->with('tags')->get()->flatMap(function($item){
            return [$item->tags->name];
        })->toArray();
        $tags = Tags::all()->pluck('name', 'name');
        //$dataTypeContent = $this->getSeo($dataTypeContent, $slug);
        return view($view, compact('dataType', 'dataTypeContent', 'category', 'tags', 'etags'));
    }

    // POST BR(E)AD
    public function update(Request $request, $id)
    {
        $slug = $request->segment(2);
        $model = new DataType();
        $dataType = $model->newQueryWithoutScopes()->where('slug', '=', $slug)->first();

        $data = call_user_func([$dataType->model_name, 'find'], $id);
        $result = $this->insertUpdateData($request, $slug, $dataType->editRows, $data);
        //生成当前内容页
        $this->generateContent($slug.'/'.$id, $request->all(), $result, []);
        //tags 更新
        $this->updateTags($request, $result, $dataType->id, $id);
        return redirect()
            ->route("admin.{$dataType->slug}.edit",$id)
            ->with([
                'message'    => "更新{$dataType->display_name_singular}成功",
                'alert-type' => 'success',
            ]);
    }

    //***************************************
    //
    //                   /\
    //                  /  \
    //                 / /\ \
    //                / ____ \
    //               /_/    \_\
    //
    //
    // Add a new item of our Data Type BRE(A)D
    //
    //****************************************

    public function create(Request $request)
    {
        $slug = $request->segment(2);
        $model = new DataType();
        $dataType = $model->newQueryWithoutScopes()->where('slug', '=', $slug)->first();


        $view = 'admin.bread.edit-add';

        if (view()->exists("admin.$slug.edit-add")) {
            $view = "admin.$slug.edit-add";
        } elseif (view()->exists("admin.$slug.add")) {
            $view = "admin.$slug.add";
        }
        //获取所有栏目
        $model_name = $dataType->name;
        $category = Category::where(['model' => $model_name])->get()->keyBy(function($item){return $item->id;})->map(function($value){
            return $value->title;
        })->toArray();
        if(empty($category) && $slug!='menus'){
            Toastr::error('请先添加栏目');
            return redirect()->route("admin.category.create");
        }
        //获取已经存在的tags
        $tags = Tags::all()->pluck('name', 'name');
        return view($view, compact('dataType','category', 'tags'));
    }

    // POST BRE(A)D
    public function store(Request $request)
    {
        $slug = $request->segment(2);
        $model = new DataType();
        $dataType = $model->newQueryWithoutScopes()->where('slug', '=', $slug)->first();


        if (function_exists('voyager_add_post')) {
            $url = $request->url();
            voyager_add_post($request);
        }
        if(empty($request->get('category_id')) && $slug!='menus'){
            return redirect()
                ->route("admin.{$dataType->slug}.create")
                ->with([
                    'message'    => "请先选择所属栏目",
                    'alert-type' => 'error',
                ]);
        }
        $data = new $dataType->model_name();
        $result = $this->insertUpdateData($request, $slug, $dataType->addRows, $data);
        if($slug!='menus'){
            //生成当前内容页
            $this->generateContent($slug.'/'.$result->id, $request->all(), $result, []);
            //如果存在tags
            if($request->get('tags')){
                $this->saveTags($request, $result, $dataType->id);
            }
        }



        return redirect()
            ->route("admin.{$dataType->slug}.index")
            ->with([
                'message'    => "新增{$dataType->display_name_singular}成功",
                'alert-type' => 'success',
            ]);
    }

    //***************************************
    //                _____
    //               |  __ \
    //               | |  | |
    //               | |  | |
    //               | |__| |
    //               |_____/
    //
    //         Delete an item BREA(D)
    //
    //****************************************

    public function destroy(Request $request, $id)
    {
        $slug = $request->segment(2);
        $model = new DataType();
        $dataType = $model->newQueryWithoutScopes()->where('slug', '=', $slug)->first();


        $data = call_user_func([$dataType->model_name, 'find'], $id);

        foreach ($dataType->deleteRows as $row) {
            if ($row->type == 'image') {
                $this->deleteFileIfExists('/uploads/'.$data->{$row->field});

                $options = json_decode($row->details);

                if (isset($options->thumbnails)) {
                    foreach ($options->thumbnails as $thumbnail) {
                        $ext = explode('.', $data->{$row->field});
                        $extension = '.'.$ext[count($ext) - 1];

                        $path = str_replace($extension, '', $data->{$row->field});

                        $thumb_name = $thumbnail->name;

                        $this->deleteFileIfExists('/uploads/'.$path.'-'.$thumb_name.$extension);
                    }
                }
            }
        }

        $data = $data->destroy($id)
            ? [
                'message'    => "删除{$dataType->display_name_singular}成功",
                'alert-type' => 'success',
            ]
            : [
                'message'    => "删除 {$dataType->display_name_singular}失败",
                'alert-type' => 'error',
            ];

        return redirect()->route("admin.{$dataType->slug}.index")->with($data);
    }

    public function builder($id)
    {
        $menu = Menu::find($id);

        return view('admin.menus.builder', compact('menu'));
    }

    public function delete_menu($id)
    {
        $item = MenuItem::find($id);
        $menuId = $item->menu_id;
        $item->destroy($id);

        return redirect()
            ->route('admin.menu.builder', [$menuId])
            ->with([
                'message'    => '删除菜单成功.',
                'alert-type' => 'success',
            ]);
    }

    public function add_item(Request $request)
    {
        $data = $request->all();
        $highestOrderMenuItem = MenuItem::where('parent_id', '=', null)
            ->orderBy('order', 'DESC')
            ->first();

        $data['order'] = isset($highestOrderMenuItem->id)
            ? intval($highestOrderMenuItem->order) + 1
            : 1;

        MenuItem::create($data);

        return redirect()
            ->route('admin.menu.builder', [$data['menu_id']])
            ->with([
                'message'    => '新建菜单成功.',
                'alert-type' => 'success',
            ]);
    }

    public function update_item(Request $request)
    {
        $id = $request->input('id');
        $data = $request->except(['id']);
        $menuItem = MenuItem::find($id);
        $menuItem->update($data);

        return redirect()
            ->route('admin.menu.builder', [$menuItem->menu_id])
            ->with([
                'message'    => '更新菜单成功.',
                'alert-type' => 'success',
            ]);
    }

    public function order_item(Request $request)
    {
        $menuItemOrder = json_decode($request->input('order'));

        $this->orderMenu($menuItemOrder, null);
    }

    private function orderMenu(array $menuItems, $parentId)
    {
        foreach ($menuItems as $index => $menuItem) {
            $item = MenuItem::find($menuItem->id);
            $item->order = $index + 1;
            $item->parent_id = $parentId;
            $item->save();

            if (isset($menuItem->children)) {
                $this->orderMenu($menuItem->children, $item->id);
            }
        }
    }
}
