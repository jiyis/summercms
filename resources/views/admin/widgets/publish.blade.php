<div class="box box-success">
    <div class="box-header with-border">
      	<h3 class="box-title">发布设置</h3>
      	
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      	<div class="row">
            <div class="col-sm-12 publish-label"><i class="fa fa-cloud-upload"></i> 发布状态：{!! Form::checkbox('published', old('published'),1, ['class' => 'my-switch']) !!}</div>
      		<div class="col-sm-12 publish-label"><i class="fa fa-history" style="font-size:16px"></i> 现有版本：<span>5 <a href="#" style="text-decoration:underline">编 辑</a></span></div>
			<div class="col-sm-12 publish-label"><i class="fa fa-calendar"></i> 更新时间：<span>2016-08-01 14:56:29</span></div>
      	</div>
      	<!-- /.row -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
    	<div class="row">
    		<!--<a href="{{ route('admin.page.index') }}" class="footer-delete-btn">删  除</a>
    		<a href="{{ route('admin.page.index') }}" class="btn btn-default btn-xs footer-btn">返  回</a>-->
    		<a href="javascript:void(0);" id="publish-btn" class="btn btn-success btn-xs footer-btn">发  布</a>
                <a href="javascript:void(0);" target="_blank" id="preview-btn" class="btn btn-warning btn-xs footer-btn">预览</a>
    	</div>
    	<!-- /.row -->
    </div>
    <!-- /.box-footer -->
</div>
