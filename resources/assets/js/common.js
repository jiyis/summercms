jQuery(document).ready(function () {

    //列表页全选
    $('table #selectall').on('ifChecked', function(event){
        $(this).parents('table').find('.selectall-item').iCheck('check');
    });
    $('table #selectall').on('ifUnchecked', function(event){
        $(this).parents('table').find('.selectall-item').iCheck('uncheck');
    });
    //Laravel csrf token verify
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Menu set active
    $(".sub-menu-a,.menu-a").click(function (e) {
        $.cookie('menu-selected', $(this).attr("href"), {path: '/'});
    });

    $(".datatable").DataTable({
        columnDefs:[{
            orderable:false,//禁用排序
            'aTargets':[0,-1]   //指定的列
        }],
        autoWidth: true,
        //"bPaginate": false,
        language: {
            url: '/assets/language/datatables-zh.json'
        },
    });
    
    $('.select2').select2();
    $('.select2').css('width','100%');

    $('input[class!="my-switch"]').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });


    $("[data-toggle='tooltip']").tooltip();
});

window.addEventListener("load", function() {
    $('#loadpage').addClass('loaded');
    setTimeout(function () {
        $('#loadpage').remove();
    },300);
});

var Rbac = window.Rbac || {};

/**
 * 常用AJAX
 * @module Rbac.common
 */
(function (Rbac) {

    Rbac.ajax = {
        /**
         * ajax 请求
         * @param params
         * {
		 * type:'POST',data:请求数据, href:ajax请求url, successTitle:成功提示,  successFnc:成功回调, errorFnc:失败回调
		 * }
         */
        request: function (params) {
            var params = params || {},
                _type = params.type || 'POST',
                _data = params.data || {},
                _close = params.close || {},
                _successFnc = params.successFnc || function () {
                        window.location.reload();
                    },
                _successTitle = params.successTitle || '操作成功',
                _errorFnc = params.errorFnc || function () {
                        swal('操作失败', 'error');
                    };
            $.ajax({
                url: params.href, type: _type, data: _data
            }).done(function (data) {
                if (data.status == 1) {
                    swal({
                        title: _successTitle,
                        type: 'success',
                        confirmButtonColor: '#8CD4F5',
                        closeOnConfirm: _close
                    }, function () {
                        _successFnc()
                    });
                } else if (data.status == -1) {
                    swal(data.msg, '', 'error');
                } else {
                    _errorFnc()
                }
            }).fail(function () {
                swal('服务器请求错误', '', 'error');
            });
        },
        /**
         * 删除单条记录
         * @param params
         * {
		 * data:请求数据, confirmTitle:提示标题, href:ajax请求url, successTitle:删除成功提示,  successFnc:删除成功回调, errorFnc:删除失败回调
		 * }
         * @returns {jQuery}
         */
        delete: function (params) {
            var params = params || {},
                _confirmTitle = params.confirmTitle || '确定删除该记录吗?',
                _successFnc = params.successFnc || function () {
                        window.location.reload();
                    },
                _successTitle = params.successTitle || '删除成功',
                _errorFnc = params.errorFnc || function () {
                        swal('删除失败', 'error');
                    }, _this = this;
            swal({
                title: _confirmTitle,
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                if (params.type == undefined) {
                    params.type = 'DELETE';
                }
                _this.request(params);
            });
        },
        /**
         *
         * @param params
         * {
		 * confirmTitle:提示标题, href:ajax请求url, successTitle:删除成功提示,  successFnc:删除成功回调, errorFnc:删除失败回调
		 * }
         * @returns {jQuery}
         */
        deleteAll: function (params) {
            var ids = [];
            $(".selectall-item").each(function (e) {
                if ($(this).prop('checked')) {
                    ids.push($(this).val());
                }
            });

            if (ids.length == 0) {
                swal('请选择需要删除的记录', '', 'warning');
                return false;
            }
            params.data = {ids: ids};
            params.type = 'POST';
            this.delete(params);
        }
    };
})(Rbac);

var Summer = window.Summer || {};

/**
 * 等待时间比较长的ajax
 * @module
 */
(function (Summer) {

    Summer.queue = {
        request: function (params) {
            var params = params || {},
                _data = params.data || {},
                _title = params.title || '正在发布...',
                _type = params.type || 'info',
                _html = params.html || "可能会需要一点时间，请耐心等待...<br><br><br><br>",
                _successTitle = params.successTitle || '操作成功';

            swal.queue([{
                type: _type,
                title: _title,
                html: _html,
                showConfirmButton: false,
                allowEscapeKey: false,
                allowOutsideClick: false,
                onOpen: function () {
                    return new Promise(function (resolve) {
                        Rbac.ajax.request({
                            successTitle:_successTitle,
                            close: true,
                            href: params.href,
                            data:_data,
                            successFnc: function () {
                                return false;
                            }
                        });
                    })
                }
            }])
        }
    };
})(Summer);