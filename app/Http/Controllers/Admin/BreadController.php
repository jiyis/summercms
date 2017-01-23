<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\ResourceManage;
use App\Http\Controllers\Admin\Traits\TagsManage;
use App\Models\Category;
use App\Models\Tags;
use App\Models\TagsData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\DataType;
use Toastr;


class BreadController extends BaseController
{
    use ResourceManage, TagsManage;

    public function __construct()
    {
        parent::__construct();

    }
    //***************************************
    //               ____
    //              |  _ \
    //              | |_) |
    //              |  _ <
    //              | |_) |
    //              |____/
    //
    //      Browse our Data Type (B)READ
    //
    //****************************************

    public function index(Request $request)
    {
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $slug = $request->segment(2);

        // GET THE DataType based on the slug
        $dataType = DataType::where('slug', '=', $slug)->first();

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
        $dataType = DataType::where('slug', '=', $slug)->first();

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
        $dataType = DataType::where('slug', '=', $slug)->first();
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
        $dataType = DataType::where('slug', '=', $slug)->first();
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
        $dataType = DataType::where('slug', '=', $slug)->first();

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
        if(empty($category)){
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
        $dataType = DataType::where('slug', '=', $slug)->first();

        if (function_exists('voyager_add_post')) {
            $url = $request->url();
            voyager_add_post($request);
        }
        if(empty($request->get('category_id'))){
            return redirect()
                ->route("admin.{$dataType->slug}.create")
                ->with([
                    'message'    => "请先选择所属栏目",
                    'alert-type' => 'error',
                ]);
        }
        $data = new $dataType->model_name();
        $result = $this->insertUpdateData($request, $slug, $dataType->addRows, $data);
        //生成当前内容页
        $this->generateContent($slug.'/'.$result->id, $request->all(), $result, []);
        //如果存在tags
        if($request->get('tags')){
            $this->saveTags($request, $result, $dataType->id);
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
        $dataType = DataType::where('slug', '=', $slug)->first();

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
