<!-- cover widgets -->
<div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">封面图片</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <div class="form-group">
          <div class="col-sm-12">
              {!! Form::text('seotitle', old('seotitle'), ['class' => 'form-control','placeholder' => 'SEO标题']) !!}
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
              {!! Form::text('keyword', old('keyword'), ['class' => 'form-control','placeholder' => 'SEO关键词']) !!}
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
              {!! Form::textarea('description', old('description'), ['class' => 'form-control','placeholder' => '| SEO页面描述']) !!}
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->