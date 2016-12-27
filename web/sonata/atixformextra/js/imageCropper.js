var ImageCropper = function(id, config, trads){
    var obj = this;

    obj.id = id;
    obj.trads= trads;
    obj.imgAreaSelect = null;

    obj.init = function(){ //On ready; we init the component

        obj.setConfig(config);
        //Erreur config
        if(obj.config.selectionWidth < obj.config.minWidth){
            alert(obj.trads.configWidthError);
            return;
        }
        if(obj.config.selectionHeight < obj.config.minHeight){
            alert(obj.trads.configHeightError);
            return;
        }
        // $("#preview_"+obj.id).width(obj.config.minWidth).height(obj.config.minHeight);

        obj.handleUpload();
        obj.initCropSelection();
        obj.initClickOnCropButton();
        obj.initClickOnDeleteButton();
        obj.handleRequired();

        $('#cropModal-'+obj.id).on('shown.bs.modal', function () {
            obj.refreshCropper();
        });

    }
    obj.setConfig = function(config){
        var defaultConfig= {
            "minWidth":50,
            "minHeight":50,
            "maxWidth":600,
            "maxHeight":600,
            "selectionWidth":100,
            "selectionHeight":100,
            "isRemovable":false,
            "forceCrop":true
        };
        for(var i in config){
            defaultConfig[i] = config[i];
        }
        obj.config = defaultConfig;

    }
    obj.handleUpload = function(){
        $('#file_'+obj.id).on('change', function (e) {
            var files = $(this)[0].files;
            if (files.length > 0) {
                var file = files[0];
                obj.changeImage(window.URL.createObjectURL(file));
                $('.alert-required-'+obj.id).addClass('hidden');
                $('.btn-showDelete-'+obj.id).removeClass('hidden');
            }
        });
    }
    obj.changeImage = function(url){
        $('body').append($('<img style="display:none;" id="tempImageLoader" src="'+url+'" />'))
        $('img#tempImageLoader').load(function(){

            if($(this).width() < obj.config.minWidth){
                var trad = obj.trads.imageTooLargeError.replace('%image%', $(this).width()).replace('%config%', obj.config.minWidth)
                alert(trad);
                return;
            }
            if($(this).height() < obj.config.minHeight){
                var trad = obj.trads.imageTooTallError.replace('%image%', $(this).height()).replace('%config%', obj.config.minHeight)
                alert(trad);
                alert('Cette image a une hauteur inférieure à celle authorisée ('+$(this).height()+'<'+obj.config.minHeight+'). Veuillez choisir une image plus grande.');
                return;
            }
            obj.toDataUrl($(this).attr('src'), function(res){

                $('#preview_'+obj.id+' img, img#image_'+obj.id).attr('src', res);
                obj.refreshCropper();

                if(obj.config.forceCrop) {
                    $('.btn-showCrop-'+obj.id).click();
                }else{
                    obj.refreshInput(res);
                    $('#thumbnail-'+obj.id+ ' img').attr('src', res);
                    $('.btn-showCrop-'+obj.id).removeClass('hidden');
                }
            });
        });
    }
    obj.refreshCropper = function(){
        var coords = obj.getCoordsSquare($('img#image_'+obj.id));
        obj.imgAreaSelect.setSelection(coords.x1, coords.y1, coords.x2, coords.y2, true);

        obj.imgAreaSelect.update();
        obj.setCoordinatesInput(obj.imgAreaSelect.getSelection());
        obj.preview(null, obj.imgAreaSelect.getSelection());
    }
    obj.refreshInput = function(data){
        $('#'+obj.id).val(data);
    }
    obj.refreshCImgProps = function(){
        $img = $('img#image_'+obj.id)
        obj.widthImg = $img.width();
        obj.heightImg = $img.height();
    }
    obj.getCoordsSquare = function($img){
        obj.refreshCImgProps();
        var x1 = (obj.widthImg / 2) - (obj.config.selectionWidth / 2);
        var y1 = (obj.heightImg / 2) - (obj.config.selectionHeight / 2);

        var coords = {
            x1 : x1,
            y1 : y1,
            x2 : x1+ obj.config.selectionWidth,
            y2 : y1+ obj.config.selectionHeight
        }
        return coords;
    }
    obj.initCropSelection = function(){

        $('#preview_'+obj.id).width(obj.config.selectionWidth);
        $('#preview_'+obj.id).height(obj.config.selectionHeight);

        $("#thumbnail-"+obj.id+" img").css(
        {
            'maxWidth': obj.config.selectionWidth,
            'maxHeight': obj.config.selectionWidth
        });
        $('img#image_'+obj.id).ready(function () {



            var $img = $('img#image_'+obj.id);
            var coords = obj.getCoordsSquare($img);

            var imgAreaSelect = $img.imgAreaSelect({
                handles: true,
                instance: true,
                minWidth: obj.config.minWidth,
                minHeight: obj.config.minHeight,
                maxWidth: obj.config.maxWidth,
                maxHeight: obj.config.maxHeight,
                x1: coords.x1, y1: coords.y1, x2: coords.x2, y2: coords.y2,
                aspectRatio: obj.config.selectionWidth+':'+obj.config.selectionHeight,
                onSelectChange: obj.preview,
                persistent:true,
                parent:'#cropModal-'+obj.id,
                onInit: function(){
                    obj.preview(null, obj.imgAreaSelect.getSelection());
                },
                onSelectEnd: function (img, selection) {
                    // console.log(selection);
                    obj.setCoordinatesInput(selection);

                }
            });
            obj.imgAreaSelect = imgAreaSelect;
        });
    }
    obj.setCoordinatesInput = function(selection){
        $('input[name="x_'+obj.id+'"]').val(selection.x1);
        $('input[name="y_'+obj.id+'"]').val(selection.y1);
        $('input[name="w_'+obj.id+'"]').val(selection.width);
        $('input[name="h_'+obj.id+'"]').val(selection.height);
    }
    obj.initClickOnCropButton = function(){
        $('.btn-crop_'+obj.id).click(function(e){
            e.preventDefault();
            var file = $('#file_'+obj.id)[0].files[0];
            var ajaxCropUrl = $(this).attr('href');
            var src = $('img#image_'+obj.id).attr('src')

            // obj.toDataUrl(src, function(res){
                // console.log(res);
                $.ajax({
                    url: ajaxCropUrl,
                    type: 'POST',
                    data: {
                        image: src,
                        x: $('input[name="x_'+obj.id+'"]').val(),
                        y: $('input[name="y_'+obj.id+'"]').val(),
                        width: $('input[name="w_'+obj.id+'"]').val(),
                        height: $('input[name="h_'+obj.id+'"]').val()
                    }
                })
                .done(function(data) {
                    $('#thumbnail-'+obj.id+ ' img').attr('src', data);
                    obj.refreshInput(data);
                    $('#cropModal-'+obj.id).modal('hide');
                    // $('body').append($('<img width="100" height="100" class="returnServer" src="'+data+'"/>'));
                })
                .fail(function() {
                    alert(obj.trads.ajaxError);
                })
                .always(function() {
                });

            // });

        })

    }
    obj.toDataUrl = function(url, callback){
        var xhr = new XMLHttpRequest();
        xhr.responseType = 'blob';
        xhr.onload = function() {
          var reader  = new FileReader();
          reader.onloadend = function () {
              callback(reader.result);
          }
          reader.readAsDataURL(xhr.response);
        };
        xhr.open('GET', url);
        xhr.send();
    }
    obj.widthImg = 100;
    obj.heightImg = 100;
    obj.preview = function(img, selection){

        var scaleX = obj.config.selectionWidth / (selection.width || 1);
        var scaleY = obj.config.selectionHeight / (selection.height || 1);
        $('#preview_'+obj.id+' img').css({
            width: Math.round(scaleX * obj.widthImg) + 'px',
            height: Math.round(scaleY * obj.heightImg) + 'px',
            marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
            marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
        });
    }
    obj.initClickOnDeleteButton = function(){
        $('.btn-showDelete-'+obj.id).click(function(e){
            e.preventDefault();
            $(this).addClass('hidden');
            $('#thumbnail-'+obj.id+ ' img').attr('src', '');
            $('#file_'+obj.id).val('');
            obj.refreshInput('');
            $('.btn-showCrop-'+obj.id).addClass('hidden');
        });
    }
    obj.handleRequired = function(){
        var form = $('#'+obj.id)[0].form;
        $(form).submit(function(e){
            if(obj.config.isRequired){
                if($('#'+obj.id).val()==''){
                    e.preventDefault();
                    $('.alert-required-'+obj.id).removeClass('hidden');
                }
            }
        })
    }
}
