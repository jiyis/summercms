<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\DataType;
use App\Models\Category;
use App\Models\Tags;

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

        //$dataTypeContent = $this->getSeo($dataTypeContent, $slug);
        return view($view, compact('dataType', 'dataTypeContent'));
    }

    // POST BR(E)AD
    public function update(Request $request, $id)
    {
        $slug = $request->segment(2);
        $model = new DataType();
        $dataType = $model->newQueryWithoutScopes()->where('slug', '=', $slug)->first();

        $data = call_user_func([$dataType->model_name, 'find'], $id);
        $result = $this->insertUpdateData($request, $slug, $dataType->editRows, $data);

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
        return view($view, compact('dataType'));
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

        $data = new $dataType->model_name();
        $result = $this->insertUpdateData($request, $slug, $dataType->addRows, $data);
       
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
    public function insertUpdateData($request, $slug, $rows, $data)
    {
        $rules = [];
        foreach ($rows as $row) {
            $options = json_decode($row->details);
            if (isset($options->rule)) {
                $rules[$row->field] = $options->rule;
            }

            $content = $this->getContentBasedOnType($request, $slug, $row);

            if ($content === null) {
                if (isset($data->{$row->field})) {
                    $content = $data->{$row->field};
                }
                if ($row->field == 'password') {
                    $content = $data->{$row->field};
                }
            }
            $data->{$row->field} = $content;
        }

        $this->validate($request, $rules);
        $data->save();
        return $data;
    }
    public function getContentBasedOnType(Request $request, $slug, $row)
    {
        $content = null;
        switch ($row->type) {
            /********** PASSWORD TYPE **********/
            case 'password':
                $pass_field = $request->input($row->field);

                if (isset($pass_field) && !empty($pass_field)) {
                    return bcrypt($request->input($row->field));
                }
                break;

            /********** CHECKBOX TYPE **********/
            case 'checkbox':
                $checkBoxRow = $request->input($row->field);
                if (isset($checkBoxRow)) {
                    return implode(',',$checkBoxRow);
                }
                break;

            /********** FILE TYPE **********/
            case 'file':
                $file = $request->file($row->field);
                $filename = Str::random(20);
                $path = $slug.'/'.date('F').date('Y').'/';

                $fullPath = $path.$filename.'.'.$file->getClientOriginalExtension();

                Storage::put(config('voyager.storage.subfolder').$fullPath, (string) $file, 'public');

                return $fullPath;
            // no break

            /********** IMAGE TYPE **********/
            case 'image':
                if ($request->hasFile($row->field)) {
                    $storage_disk = 'local';
                    $file = $request->file($row->field);
                    $filename = Str::random(20);

                    //$path = $slug.'/'.date('F').date('Y').'/';
                    $datepath = date('Ymd', time());
                    $extName  = $file->getClientOriginalExtension();
                    $fileName = time() . str_random(3);
                    //$lastpath = public_path() . config('common.images') . str_finish($datepath, '/');
                    $path = config('common.images') . str_finish($datepath, '/');

                    $fullPath = $path.$filename.'.'.$file->getClientOriginalExtension();

                    $options = json_decode($row->details);

                    if (isset($options->resize) && isset($options->resize->width) && isset($options->resize->height)) {
                        $resize_width = $options->resize->width;
                        $resize_height = $options->resize->height;
                    } else {
                        $resize_width = 1800;
                        $resize_height = null;
                    }

                    /*$image = Image::make($file)
                        ->resize($resize_width, $resize_height, function (Constraint $constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->encode($file->getClientOriginalExtension(), 75);*/


                    $image = Image::make($file)
                        ->fit($resize_width, $resize_height)
                        ->encode($file->getClientOriginalExtension(), 75);

                    Storage::put(config('voyager.storage.subfolder').$fullPath, (string) $image, 'public');

                    if (isset($options->thumbnails)) {
                        foreach ($options->thumbnails as $thumbnails) {
                            if (isset($thumbnails->name) && isset($thumbnails->scale)) {
                                $scale = intval($thumbnails->scale) / 100;
                                $thumb_resize_width = $resize_width;
                                $thumb_resize_height = $resize_height;
                                if ($thumb_resize_width != 'null') {
                                    $thumb_resize_width = $thumb_resize_width * $scale;
                                }
                                if ($thumb_resize_height != 'null') {
                                    $thumb_resize_height = $thumb_resize_height * $scale;
                                }
                                $image = Image::make($file)
                                    ->resize($thumb_resize_width, $thumb_resize_height, function (Constraint $constraint) {
                                        $constraint->aspectRatio();
                                        $constraint->upsize();
                                    })
                                    ->encode($file->getClientOriginalExtension(), 75);
                                Storage::put(config('voyager.storage.subfolder').$path.$filename.'-'.$thumbnails->name.'.'.$file->getClientOriginalExtension(),
                                    (string) $image, 'public');
                            } elseif (isset($thumbnails->crop)) {
                                foreach ($thumbnails->crop as $crop) {
                                    if(isset($crop->width) && isset($crop->height)) {
                                        $crop_width = $crop->width;
                                        $crop_height = $crop->height;
                                        $file_name = $path.$filename.'_'.$crop_width.'_'.$crop_height.'.'.$file->getClientOriginalExtension();
                                        $image = Image::make($file)
                                            ->fit($crop_width, $crop_height)
                                            ->encode($file->getClientOriginalExtension(), 75);
                                        Storage::put(config('voyager.storage.subfolder').$file_name, (string) $image, 'public');
                                    }
                                }
                            } elseif (isset($options->thumbnails) && isset($thumbnails->crop->width) && isset($thumbnails->crop->height)) {
                                $crop_width = $thumbnails->crop->width;
                                $crop_height = $thumbnails->crop->height;
                                $image = Image::make($file)
                                    ->fit($crop_width, $crop_height)
                                    ->encode($file->getClientOriginalExtension(), 75);
                                Storage::put(config('voyager.storage.subfolder').$path.$filename.'-'.$thumbnails->name.'.'.$file->getClientOriginalExtension(),
                                    (string) $image, 'public');
                            }

                        }
                    }

                    return $fullPath;
                }
                break;

            /********** ALL OTHER TEXT TYPE **********/
            default:
                return $request->input($row->field);
            // no break
        }

        return $content;
    }

    public function generate_views(Request $request)
    {
        //$dataType = DataType::where('slug', '=', $slug)->first();
    }

    private function deleteFileIfExists($path)
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}
