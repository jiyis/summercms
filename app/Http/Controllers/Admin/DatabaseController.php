<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Console\AppNamespaceDetectorTrait;
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
    use AppNamespaceDetectorTrait;
    use DatabaseUpdate;

    public function index()
    {
        return view('admin.tools.database.index');
    }

    public function create()
    {
        return view('admin.tools.database.edit-add');
    }

    public function store(Request $request)
    {
        $tableName = getModelTableName($request->name);

        try {
            Schema::create($tableName, function (Blueprint $table) use ($request) {
                foreach ($this->buildQuery($request) as $query) {
                    $query($table);
                }
            });

            if (isset($request->create_model) && $request->create_model == 'on') {
                Artisan::call('make:model', [
                    'name' => 'Models/'.ucfirst(camel_case($tableName)),
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
        $rows = $this->describeTable(getModelTableName($table, true));
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
        $tableName = getModelTableName($request->name);
        $this->renameTable(getModelTableName($request->original_name), $tableName);
        $this->renameColumns($request, $tableName);
        $this->dropColumns($request, $tableName);
        $this->updateColumns($request, $tableName);
        \File::delete(app_path('/Models/').ucfirst(camel_case(getModelTableName($request->original_name))).'.php');
        Artisan::call('make:model', [
            'name' => 'Models/'.ucfirst(camel_case($tableName)),
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
        return response()->json($this->describeTable(getModelTableName($table,true)));
    }

    public function delete($table)
    {
        $table = getModelTableName($table);
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
        $table = getModelTableName($request->input('table'), true);

        return view('admin.tools.database.edit-add-bread', $this->prepopulateBreadInfo($table));
    }

    private function prepopulateBreadInfo($table)
    {
        $displayName = Str::singular(implode(' ', explode('_', Str::title($table))));

        return [
            'table'               => $table,
            'slug'                => Str::slug($table),
            'display_name'        => $displayName,
            'display_name_plural' => Str::plural($displayName),
            'model_name'          => $this->getAppNamespace().'\\'.Str::studly(Str::singular($table)),
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