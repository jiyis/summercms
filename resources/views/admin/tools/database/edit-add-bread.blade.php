@extends('admin.layouts.voyager')

@section('css')
    @parent
    <link href="{{ asset('assets/package/voyager/bootstrap-toggle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/package/voyager/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/package/voyager/jquery-ui.css') }}">
    <script type="text/javascript" src="{{ asset('assets/package/voyager/jsonarea.min.js') }}"></script>
    <script>var valid_json = [];</script>
@endsection


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="page-title">
                <i class="voyager-data"></i> @if(isset($dataType->id)){{ '编辑 ' . $dataType->name . ' 数据表模型' }}@elseif(isset($table)){{ '新增 ' . $table . ' 数据表模型' }}@endif
            </div>
        </section>
        @if(isset($dataType->name))
            <?php $table = env('DB_PREFIX').$dataType->name ?>
        @endif


         <?php $tableData = DB::select("DESCRIBE ${table}"); ?>

        <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <form role="form"
                      action="@if(isset($dataType->id)){{ route('admin.database.edit_bread', $dataType->id) }}@else{{ route('admin.database.store_bread') }}@endif"
                      method="POST">

                    <div class="panel panel-primary panel-bordered">

                        <div class="panel-heading">
                            <h3 class="panel-title">编辑 {{ $table }} 数据表信息:</h3>
                        </div>

                        <table id="users" class="table table-hover">
                            <thead>
                            <tr>
                                <th>字段名称</th>
                                <th>字段信息</th>
                                <th>是否可见</th>
                                <th>字段类型</th>
                                <th>显示名称</th>
                                <th>字段细节</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tableData as $data)
                                @if(isset($dataType->id))
                                    <?php $dataRow = App\Models\DataRow::where('data_type_id', '=',
                                            $dataType->id)->where('field', '=', $data->Field)->first(); ?>
                                @endif
                                <tr>
                                    <td><h4><strong>{{ $data->Field }}</strong></h4></td>
                                    <td>
                                        <strong>类型:</strong> <span>{{ $data->Type }}</span><br/>
                                        <strong>主键:</strong> <span>{{ $data->Key }}</span><br/>
                                        <strong>必填:</strong>
                                        @if($data->Null == "NO")
                                            <span>是</span>
                                            <input type="hidden" value="1" name="field_required_{{ $data->Field }}"
                                                   checked="checked">
                                        @else
                                            <span>否</span>
                                            <input type="hidden" value="0" name="field_required_{{ $data->Field }}">
                                        @endif
                                    </td>
                                    <td>
                                        <input type="checkbox"
                                               name="field_browse_{{ $data->Field }}" @if(isset($dataRow->browse) && $dataRow->browse){{ 'checked="checked"' }}@elseif($data->Key == 'PRI')@elseif($data->Type == 'timestamp' && $data->Field == 'updated_at')@elseif(!isset($dataRow->browse)){{ 'checked="checked"' }}@endif>
                                        浏览<br/>
                                        <input type="checkbox"
                                               name="field_read_{{ $data->Field }}" @if(isset($dataRow->read) && $dataRow->read){{ 'checked="checked"' }}@elseif($data->Key == 'PRI')@elseif($data->Type == 'timestamp' && $data->Field == 'updated_at')@elseif(!isset($dataRow->read)){{ 'checked="checked"' }}@endif>
                                        读取<br/>
                                        <input type="checkbox"
                                               name="field_edit_{{ $data->Field }}" @if(isset($dataRow->edit) && $dataRow->edit){{ 'checked="checked"' }}@elseif($data->Key == 'PRI')@elseif($data->Type == 'timestamp' && $data->Field == 'updated_at')@elseif(!isset($dataRow->edit)){{ 'checked="checked"' }}@endif>
                                        编辑<br/>
                                        <input type="checkbox"
                                               name="field_add_{{ $data->Field }}" @if(isset($dataRow->add) && $dataRow->add){{ 'checked="checked"' }}@elseif($data->Key == 'PRI')@elseif($data->Type == 'timestamp' && $data->Field == 'created_at')@elseif($data->Type == 'timestamp' && $data->Field == 'updated_at')@elseif(!isset($dataRow->add)){{ 'checked="checked"' }}@endif>
                                        新增<br/>
                                        <input type="checkbox"
                                               name="field_delete_{{ $data->Field }}" @if(isset($dataRow->delete) && $dataRow->delete){{ 'checked="checked"' }}@elseif($data->Key == 'PRI')@elseif($data->Type == 'timestamp' && $data->Field == 'updated_at')@elseif(!isset($dataRow->delete)){{ 'checked="checked"' }}@endif>
                                        删除<br/>
                                    </td>
                                    <input type="hidden" name="field_{{ $data->Field }}" value="{{ $data->Field }}">
                                    <td>
                                        @if($data->Key == 'PRI')
                                            <p>主键</p>
                                            <input type="hidden" value="PRI" name="field_input_type_{{ $data->Field }}">
                                        @elseif($data->Type == 'timestamp')
                                            <p>时间戳</p>
                                            <input type="hidden" value="timestamp"
                                                   name="field_input_type_{{ $data->Field }}">
                                        @else
                                            <select name="field_input_type_{{ $data->Field }}">
                                                <option value="text" @if(isset($dataRow->type) && $dataRow->type == 'text'){{ 'selected' }}@endif>
                                                    Text Box
                                                </option>
                                                <option value="text_area" @if(isset($dataRow->type) && $dataRow->type == 'text_area'){{ 'selected' }}@endif>
                                                    Text Area
                                                </option>
                                                <option value="rich_text_box" @if(isset($dataRow->type) && $dataRow->type == 'rich_text_box'){{ 'selected' }}@endif>
                                                    富文本编辑器
                                                </option>
                                                <option value="password" @if(isset($dataRow->type) && $dataRow->type == 'password'){{ 'selected' }}@endif>
                                                    密码
                                                </option>
                                                <option value="hidden" @if(isset($dataRow->type) && $dataRow->type == 'hidden'){{ 'selected' }}@endif>
                                                    隐藏
                                                </option>
                                                <option value="checkbox" @if(isset($dataRow->type) && $dataRow->type == 'checkbox'){{ 'selected' }}@endif>
                                                    复选框
                                                </option>
                                                <option value="radio_btn" @if(isset($dataRow->type) && $dataRow->type == 'radio_btn'){{ 'selected' }}@endif>
                                                    单选框
                                                </option>
                                                <option value="select_dropdown" @if(isset($dataRow->type) && $dataRow->type == 'select_dropdown'){{ 'selected' }}@endif>
                                                    下拉框
                                                </option>
                                                <option value="file" @if(isset($dataRow->type) && $dataRow->type == 'file'){{ 'selected' }}@endif>
                                                    文件
                                                </option>
                                                <option value="image" @if(isset($dataRow->type) && $dataRow->type == 'image'){{ 'selected' }}@endif>
                                                    图片
                                                </option>
                                            </select>
                                        @endif

                                    </td>
                                    <td><input type="text" class="form-control"
                                               value="@if(isset($dataRow->display_name)){{ $dataRow->display_name }}@else{{ $data->Field }}@endif"
                                               name="field_display_name_{{ $data->Field }}"></td>
                                    <td>
                                        <textarea class="form-control json" name="field_details_{{ $data->Field }}"
                                                  id="field_details_{{ $data->Field }}">@if(isset($dataRow->details)){{ $dataRow->details }}@endif</textarea>
                                        <div id="field_details_{{ $data->Field }}_valid" class="alert-success alert"
                                             style="display:none">Valid Json
                                        </div>
                                        <div id="field_details_{{ $data->Field }}_invalid" class="alert-danger alert"
                                             style="display:none">Invalid Json
                                        </div>
                                    </td>
                                </tr>

                                <script>
                                    // do the deal
                                    var myJSONArea = JSONArea(document.getElementById('field_details_{{ $data->Field }}'), {
                                        sourceObjects: [] // optional array of objects for JSONArea to inherit from
                                    });

                                    valid_json["field_details_{{ $data->Field }}"] = false;
                                    console.log(valid_json);

                                    // then here's how you use JSONArea's update event
                                    myJSONArea.getElement().addEventListener('update', function (e) {

                                        if (e.target.value != "") {
                                            valid_json["field_details_{{ $data->Field }}"] = e.detail.isJSON;
                                        }
                                    });

                                    // then here's how you use JSONArea's update event
                                    myJSONArea.getElement().addEventListener('focusout', function (e) {
                                        if (valid_json['field_details_{{ $data->Field }}']) {
                                            $('#field_details_{{ $data->Field }}_valid').show();
                                            $('#field_details_{{ $data->Field }}_invalid').hide();
                                            var ugly = e.target.value;
                                            var obj = JSON.parse(ugly);
                                            var pretty = JSON.stringify(obj, undefined, 4);
                                            document.getElementById('field_details_{{ $data->Field }}').value = pretty;
                                        } else {
                                            $('#field_details_{{ $data->Field }}_valid').hide();
                                            $('#field_details_{{ $data->Field }}_invalid').show();
                                        }
                                    });
                                </script>

                            @endforeach
                            </tbody>
                        </table>

                    </div><!-- .panel -->

                    <div class="panel panel-primary panel-bordered">

                        <div class="panel-heading">
                            <h3 class="panel-title">{{ ucfirst($table) }} 模型信息</h3>
                        </div>

                        <div class="panel-body">
                            <div class="form-group">
                                <label for="name">数据表名</label>
                                <input type="text" class="form-control" readonly name="name" placeholder="数据表名"
                                       value="@if(isset($dataType->name)){{ $dataType->name }}@else{{ $table }}@endif">
                            </div>
                            <div class="form-group">
                                <label for="email">URL(必须不能重复)</label>
                                <input type="text" class="form-control" name="slug" placeholder="网址(ex. posts)"
                                       value="@if(isset($dataType->slug)){{ $dataType->slug }}@else{{ $slug }}@endif">
                            </div>
                            <div class="form-group">
                                <label for="email">显示名称 (单数)</label>
                                <input type="text" class="form-control" name="display_name_singular"
                                       placeholder="显示名称"
                                       value="@if(isset($dataType->display_name_singular)){{ $dataType->display_name_singular }}@else{{ $display_name }}@endif">
                            </div>
                            <div class="form-group">
                                <label for="email">显示名称 (复数)</label>
                                <input type="text" class="form-control" name="display_name_plural"
                                       placeholder="显示名称"
                                       value="@if(isset($dataType->display_name_plural)){{ $dataType->display_name_plural }}@else{{ $display_name_plural }}@endif">
                            </div>
                            <div class="form-group">
                                <label for="email">显示图标(可选) Use a <a
                                            href="{{ config('voyager.assets_path') . '/fonts/voyager/icons-reference.html' }}"
                                            target="_blank">Voyager Font Class</a></label>
                                <input type="text" class="form-control" name="icon"
                                       placeholder="显示图标"
                                       value="@if(isset($dataType->icon)){{ $dataType->icon }}@endif">
                            </div>
                            <div class="form-group">
                                <label for="email">模型名称 (例如. \App\User, 如果为空，默认为表名)</label>
                                <input type="text" class="form-control" name="model_name" placeholder="模型类名称"
                                       value="@if(isset($dataType->model_name)){{ $dataType->model_name }}@else{{ $model_name }}@endif">
                            </div>
                            <div class="form-group">
                                <label for="email">模型描述</label>
                                <textarea class="form-control" name="description"
                                          placeholder="描述">@if(isset($dataType->description)){{ $dataType->description }}@endif</textarea>
                            </div>

                            @if(isset($dataType->id))
                                <input type="hidden" value="{{ $dataType->id }}" name="id">
                                <input type="hidden" value="PUT" name="_method">
                        @endif
                        <!-- CSRF TOKEN -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">提交</button>
                            </div>
                        </div><!-- .panel-body -->

                    </div><!-- .panel -->
                </form>
            </div><!-- .col-md-12 -->
        </div><!-- .row -->
    </div><!-- .page-content -->
    </div>
    <script>
        function prettyPrint() {
            var ugly = document.getElementById('myTextArea').value;
            var obj = JSON.parse(ugly);
            var pretty = JSON.stringify(obj, undefined, 4);
            document.getElementById('myTextArea').value = pretty;
        }
    </script>

@endsection