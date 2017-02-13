<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Exception, Breadcrumbs;
use Illuminate\Console\DetectsApplicationNamespace;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Http\Controllers\Admin\Traits\DatabaseUpdate;
use App\Models\DataRow;
use App\Models\DataType;

class DatabaseController extends BaseController
{
    use DetectsApplicationNamespace;
    use DatabaseUpdate;

    public function __construct()
    {
        parent::__construct();
        Breadcrumbs::register('admin-database', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('数据库管理', route('admin.database'));
        });
    }

    public function index()
    {
        Breadcrumbs::register('admin-database-index', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-database');
            $breadcrumbs->push('数据表列表', route('admin.database'));
        });

        return view('admin.tools.database.index');
    }

    public function create()
    {
        Breadcrumbs::register('admin-database-edit', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-database');
            $breadcrumbs->push('操作数据表', route('admin.database.create_table'));
        });

        return view('admin.tools.database.edit-add');
    }

    public function store(Request $request)
    {
        $tableName = getModelTableName($request->name); //自动拼接一个cms前缀，用于区分
        try {
            Schema::create($tableName, function (Blueprint $table) use ($request) {
                foreach ($this->buildQuery($request) as $query) {
                    $query($table);
                }
            });

            if (isset($request->create_model) && $request->create_model == 'on') {
                $modelName = ucfirst(camel_case(str_replace('cms_','',$tableName)));
                Artisan::call('generate:model', [
                    'name' => 'Models/'.$modelName,
                    '--table' => $tableName,
                ]);
            }

            return redirect()
                ->route('admin.database')
                ->with(
                    [
                        'message'    => "新建数据表 $tableName 成功",
                        'alert-type' => 'success',
                    ]
                );
        } catch (Exception $e) {
            return back()->with(
                [
                    'message'    => '新建失败: '.$e->getMessage(),
                    'alert-type' => 'error',
                ]
            );
        }
    }

    public function edit($table)
    {
        Breadcrumbs::register('admin-database-edit', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-database');
            $breadcrumbs->push('操作数据表', route('admin.database.create_table'));
        });
        $rows = $this->describeTable($table);
        return view('admin.tools.database.edit-add', compact('table', 'rows'));
    }

    /**
     * Update database table.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $tableName = $request->name;
        $this->renameTable($request->original_name, $tableName);
        $this->renameColumns($request, $tableName);
        $this->dropColumns($request, $tableName);
        $this->updateColumns($request, $tableName);

        $modelName = ucfirst(camel_case(str_replace('cms_','',$tableName)));
        $old_modelName = ucfirst(camel_case(str_replace('cms_','',$request->original_name)));
        \File::delete(app_path('/Models/').$old_modelName.'.php');
        Artisan::call('generate:model', [
            'name' => 'Models/'.$modelName,
            '--table' => $tableName,
        ]);
        return redirect()
            ->route('admin.database')
            ->withMessage("更新数据表 {$tableName} 成功")
            ->with('alert-type', 'success');
    }

    public function reorder_column(Request $request)
    {
        if ($request->ajax()) {
            $table = $request->table;
            $column = $request->column;
            $after = $request->after;
            if ($after == null) {
                // SET COLUMN TO THE TOP
                DB::query("ALTER $table MyTable CHANGE COLUMN $column FIRST");
            }

            return 1;
        }

        return 0;
    }

    public function table($table)
    {
        return response()->json($this->describeTable($table));
    }

    public function delete($table)
    {
        try {
            Schema::drop($table);
            \File::delete(app_path('/Models/').ucfirst(camel_case($table)).'.php');
            return redirect()
                ->route('admin.database')
                ->with(
                    [
                        'message'    => "删除数据表 $table 成功",
                        'alert-type' => 'success',
                    ]
                );
        } catch (Exception $e) {
            return back()->with(
                [
                    'message'    => '删除失败: '.$e->getMessage(),
                    'alert-type' => 'error',
                ]
            );
        }
    }

    /********** BREAD METHODS **********/

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addBread(Request $request)
    {
        $table = $request->input('table');

        return view('admin.tools.database.edit-add-bread', $this->prepopulateBreadInfo($table));
    }

    private function prepopulateBreadInfo($table)
    {
        $displayName = Str::singular(implode(' ', explode('_', Str::title($table))));

        return [
            'table'               => $table,
            'slug'                => Str::slug(getModelName($table)),
            'display_name'        => $displayName,
            'display_name_plural' => Str::plural($displayName),
            'model_name'          => '\\'.$this->getAppNamespace().'Models\\'.Str::studly(Str::singular(getModelName($table))),
        ];
    }

    public function storeBread(Request $request)
    {
        $data = $this->updateDataType(new DataType(), $request->all())
            ? [
                'message'    => '新建模型成功',
                'alert-type' => 'success',
            ]
            : [
                'message'    => '新建模型失败',
                'alert-type' => 'error',
            ];

        return redirect()->route('admin.database')->with($data);
    }

    public function addEditBread($id)
    {
        return view(
            'admin.tools.database.edit-add-bread', [
            'dataType' => DataType::find($id),
        ]
        );
    }

    public function updateBread(Request $request, $id)
    {
        /** @var \App\Models\DataType $dataType */
        $dataType = DataType::find($id);
        $data = $this->updateDataType($dataType, $request->all())
            ? [
                'message'    => "更新模型 {$dataType->name} 成功",
                'alert-type' => 'success',
            ]
            : [
                'message'    => '更新模型失败',
                'alert-type' => 'error',
            ];

        return redirect()->route('admin.database')->with($data);
    }

    public function updateDataType(DataType $dataType, $requestData)
    {
        $success = $dataType->fill($requestData)->save();
        $columns = Schema::getColumnListing($dataType->name);
        foreach ($columns as $column) {
            $dataRow = DataRow::where('data_type_id', '=', $dataType->id)
                              ->where('field', '=', $column)
                              ->first();

            if (!isset($dataRow->id)) {
                $dataRow = new DataRow();
            }

            $dataRow->data_type_id = $dataType->id;
            $dataRow->required = $requestData['field_required_'.$column];

            foreach (['browse', 'read', 'edit', 'add', 'delete'] as $check) {
                if (isset($requestData["field_{$check}_{$column}"])) {
                    $dataRow->{$check} = 1;
                } else {
                    $dataRow->{$check} = 0;
                }
            }

            $dataRow->field = $requestData['field_'.$column];
            $dataRow->type = $requestData['field_input_type_'.$column];
            $dataRow->details = $requestData['field_details_'.$column];
            $dataRow->display_name = $requestData['field_display_name_'.$column];
            $dataRowSuccess = $dataRow->save();
            //自动增加一条路由
            $permissions = [
                'fid' => 0,
                'icon' => $requestData['icon'],
                'name' => 'admin.' . $requestData['slug'] . '.index',
                'display_name' => $requestData['display_name_singular'] . '管理',
                'is_menu' => 1,
                'sort' => 1,
            ];
            Permission::updateOrCreate(['name' => 'admin.' . $requestData['slug'] . '.index'], $permissions);
            // If success has never failed yet, let's add DataRowSuccess to success
            if ($success !== false) {
                $success = $dataRowSuccess;
            }
        }

        return $success !== false;
    }

    public function deleteBread($id)
    {
        /** @var \App\Models\DataType $dataType */
        $dataType = DataType::find($id);
        $data = DataType::destroy($id)
            ? [
                'message'    => "删除模型 {$dataType->name}成功",
                'alert-type' => 'success',
            ]
            : [
                'message'    => '删除模型失败',
                'alert-type' => 'danger',
            ];

        return redirect()->route('admin.database')->with($data);
    }
}
