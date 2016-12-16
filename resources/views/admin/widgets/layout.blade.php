<!-- layouts widgets -->
<div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">布局设置</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <div class="form-group">
            {!! Form::label('layout_header', '头部布局',['class'=>'col-sm-12 control-label']) !!}
            <div class="col-sm-12">
              {!! Form::select('layout_header', ['1' => '通用头部', '2' => '页面头部','3' => '活动头部','4' => '不使用布局'],old('layout_header'),['class' => 'form-control select2']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('layout_footer', '底部布局',['class'=>'col-sm-12 control-label']) !!}
            <div class="col-sm-12">
              {!! Form::select('layout_footer', ['1' => '通用底部', '2' => '页面底部','3' => '活动底部','4' => '不使用布局'],old('layout_footer'),['class' => 'form-control select2']) !!}
            </div>
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->