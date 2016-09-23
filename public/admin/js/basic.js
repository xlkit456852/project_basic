//
Array.prototype.remove=function(obj){
    for(var i =0;i <this.length;i++){
        var temp = this[i];
        if(!isNaN(obj)){
            temp=i;
        }
        if(temp == obj){
            for(var j = i;j <this.length;j++){
                this[j]=this[j+1];
            }
            this.length = this.length-1;
        }
    }
}

function getObjURL(fileObj) {
    var file=fileObj.files[0];
    var url = null;
    if (window.createObjectURL != undefined) {
        url = window.createObjectURL(file)
    } else if (window.URL != undefined) {
        url = window.URL.createObjectURL(file)
    } else if (window.webkitURL != undefined) {
        url = window.webkitURL.createObjectURL(file)
    }
    return url
}

$("body").delegate(":file", "change", function() {
    $(this).next('img').attr('src',getObjURL($(this)[0])).show().next('i').hide();
});

/*//

//保存修改
manage.save = function(id){

    $('#edit_form')

}*/

function delete_record(message,url,csrf_token){
    var confirm_result = confirm(message);
    if(confirm_result){
        $.ajax({
            type: "POST",
            url : url,
            data : {
                _method:'delete',
                _token:csrf_token,
            },
            success : function(data){
                if(data.status==1){
                    location.reload();
                }else{
                    alert(data.info);
                }
            }
        });
    }
}

function choose_yesno(obj,url,fle,csrf_token){
    var val = $(obj).attr('class');
    var yesno = 0;
    var new_class = '';
    if(val){
        if(val.indexOf('check')!==-1){
            yesno= 0;
            new_class = 'fa fa-close cyesno red';
        }
        else{
            yesno = 1;
            new_class = 'fa fa-check cyesno green';
        }

        var re = $.ajax({
            async:false,
            type: "POST",
            url : url,
            data : {
                _method:'PUT',
                param:'cyesno',
                yesno:yesno,
                fle:fle,
                _token:csrf_token,
            },
            success : function(data){
                if(data.status==1){
                    $(obj).attr('class',new_class);
                }else{
                    alert(data.info);
                }
            }
        });


    }

}
