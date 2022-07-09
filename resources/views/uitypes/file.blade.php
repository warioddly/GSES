<div class="form-group form-animate-text @error($fieldName) form-animate-error @enderror"
       >
    {!! Form::file($fieldName, array('class' => 'form-text fileName ', 'style'=>'opacity:0;position:absolute;z-index:1;')+($required?['required']:[])) !!}
    <div class="input-group">
        @if ($document != null)
            @dump($document)
            {!! Form::hidden(str_replace(']_id', '_id]', $fieldName.'_id'), $document->id, array('class' => 'form-text fileName file-id')) !!}
            <input type="text" class="form-text file-name{{$errors->has($fieldName)?' error':''}}"
                   value="{{$document->name}}" readonly>
            <span class="input-group-addon"><i class="fas fa-paperclip" title="{{__('Choose')}}"></i></span>
            <span class="input-group-addon file-clear" style="z-index: 2;position: sticky;background: none;"><i
                        class="fas fa-times" title="{{__('Clear')}}"></i></span>

            <span class="input-group-addon file-show" style="z-index: 2;position: sticky;background: none">
                <i class="fa fa-eye showMyDocument showMyVideoAudio" style="cursor: pointer; display: flex" aria-hidden="true"></i>
                <a href="" class="fa fa-eye showMyDocument showMyDocFiles" target="_blank" style="cursor: pointer; display: none; color: black; text-decoration: none" aria-hidden="true"></a>
            </span>

            <span class="input-group-addon file-download" style="z-index: 2;position: sticky;background: none;"><a
                        href="{{route('download-file', $document->name_uuid)}}" target="_blank"
                        title="{{__('Download')}}"
                        style="color:#555555;"><i class="fas fa-download"></i></a></span>
        @else
            <input type="text" class="form-text fileName file-name{{$errors->has($fieldName)?' error':''}}" value="" readonly>
            <span class="input-group-addon"><i class="fas fa-paperclip" title="{{__('Choose')}}"></i></span>

            <span class="input-group-addon file-show" style="z-index: 2;position: sticky;background: none;display:none;">
                <i class="fa fa-eye showDocument showVideoAudio" style="cursor: pointer; display: flex" aria-hidden="true"></i>
                <a href="" class="fa fa-eye showDocument showDocFiles" target="_blank" style="cursor: pointer; display: none; color: black; text-decoration: none" aria-hidden="true"></a>
            </span>
            <span class="input-group-addon file-clear" style="z-index: 2;position: sticky;background: none;display:none;">
                <i class="fas fa-times" title="{{__('Clear')}}"></i>
            </span>
        @endif
    </div>
    <span class="bar"></span>
    <label>{{$label}}</label>
    @error($fieldName)
    <em class="error">{{ __($message) }}</em>
    @enderror
</div>

@push('page-scripts')
    <script>
        $('input[name="{{ $fieldName }}"]').parent().find('.file-clear').click(function () {
            $(this).closest('.form-group').find('input[type="file"]').val('').trigger('change');
        });
        $('input[name="{{$fieldName}}"]').change(function () {
            if (this.files.length > 0) {
                var fileName = [];
                for (var file of this.files) {
                    fileName.push(file.name);
                }
                $(this).parent().find('.file-id').val('');
                $(this).parent().find('.file-name').val(fileName.join(', '));
                $(this).parent().find('.file-clear').show();
                $(this).parent().find('.file-show').show();
                $(this).parent().find('.file-download').show();
            } else {
                $(this).parent().find('.file-id').val('');
                $(this).parent().find('.file-name').val('');
                $(this).parent().find('.file-clear').hide();
                $(this).parent().find('.file-show').hide();
                $(this).parent().find('.file-download').hide();
            }
        });

        let imageSrc = null, fileSrc = null, videoSrc = null;
        let fileLink = null, fileSrc2 = null, docFileLink = null;
        const input = document.getElementById('file-input');
        const preview = '', currentUrl = window.location.href;

        try{
            fileLink = $('.file-download a').attr('href');
            docFileLink = FileExtension(fileLink);
            fileSrc2 = fileLink.split('download-file').join('view-file');
            $('a.showMyDocFiles').attr('href', fileSrc2);
            if(docFileLink != 'mp4' && docFileLink != 'mp3' && docFileLink != 'mov' && docFileLink != 'avi' && docFileLink != 'ogg' &&
                docFileLink != 'jpg' && docFileLink != 'png' && docFileLink != 'svg' && docFileLink != 'gif' && docFileLink != 'jpeg'){
                $('.showMyVideoAudio').css('display', 'none');
                $('.showMyDocFiles').css('display', 'flex');
            }
        }
        catch(e){
            //
        }

        $('.showMyDocument').click(() => {
            if(docFileLink == 'mp4' || docFileLink == 'mp3' || docFileLink == 'mov' || docFileLink == 'avi' || docFileLink == 'ogg'){
                videoSrc = fileLink;
                videoToModal();
            }
            else if(docFileLink == 'jpg' || docFileLink == 'png' || docFileLink == 'svg' || docFileLink == 'gif' || docFileLink == 'jpeg'){
                imageSrc = fileLink;
                ImageToModal();
            }
        });

        if(currentUrl.includes('edit')){
            $('.fileName').change(function (event) {

            let showDocument = document.querySelector('.showMyDocument');
            try{
                showDocument.removeEventListener('click', ImageToModal,false)
                showDocument.removeEventListener('click', videoToModal,false)
                showDocument.removeEventListener('click', fileDownload,false)
            }
            catch (e){
                //
            }

            $('.showMyVideoAudio').css('display', 'flex');
            $('.showMyDocFiles').css('display', 'none');
            $('.showMyDocFiles').attr('href', '')

            let input = $(this)[0];
            if (input.files && input.files[0]) {
                if (input.files[0].type.match('image.*')) {
                    imageSrc = window.URL.createObjectURL(event.target.files[0]);
                    let showDocument = document.querySelector('.showMyDocument');
                    showDocument.addEventListener('click', ImageToModal)
                }
                else if(input.files[0].type.match('video.*') || input.files[0].type.match('audio.*')) {
                    videoSrc = window.URL.createObjectURL(event.target.files[0]);
                    let showDocument = document.querySelector('.showMyDocument');
                    showDocument.addEventListener('click', videoToModal)
                }
                else{
                    fileSrc = window.URL.createObjectURL(event.target.files[0]);
                    $('.showMyVideoAudio').css('display', 'none');
                    $('.showMyDocFiles').css('display', 'flex');
                    let showDocument = document.querySelector('a.showMyDocument');
                    showDocument.addEventListener('click', fileDownload2)
                }
            }
        });
        }
        else{
            $('.fileName').change(function (event) {

                let showDocument = document.querySelector('.showDocument');
                try{
                    showDocument.removeEventListener('click', ImageToModal,false)
                    showDocument.removeEventListener('click', videoToModal,false)
                    showDocument.removeEventListener('click', fileDownload,false)
                }
                catch (e){
                    //
                }

                $('.showVideoAudio').css('display', 'flex');
                $('.showDocFiles').css('display', 'none');
                $('.showDocFiles').attr('href', '')

                let input = $(this)[0];
                if (input.files && input.files[0]) {
                    if (input.files[0].type.match('image.*')) {
                        imageSrc = window.URL.createObjectURL(event.target.files[0]);
                        let showDocument = document.querySelector('.showDocument');
                        showDocument.addEventListener('click', ImageToModal)
                    }
                    else if(input.files[0].type.match('video.*') || input.files[0].type.match('audio.*')) {
                        videoSrc = window.URL.createObjectURL(event.target.files[0]);
                        let showDocument = document.querySelector('.showDocument');
                        showDocument.addEventListener('click', videoToModal)
                    }
                    else{
                        fileSrc = window.URL.createObjectURL(event.target.files[0]);
                        $('.showVideoAudio').css('display', 'none');
                        $('.showDocFiles').css('display', 'flex');
                        let showDocument = document.querySelector('a.showDocument');
                        showDocument.addEventListener('click', fileDownload)
                    }
                }
            });
        }
        function fileDownload(){
            $('.showDocFiles').attr('href', fileSrc)
        }
        function fileDownload2(){
            $('.showMyDocFiles').attr('href', fileSrc)
        }
        function ImageToModal(){
            $("body").append("<div class='popup'>"+
                "<div class='popup_bg'></div>"+
                "<img alt='' src=" + imageSrc + " class='popup_img' style='transform: scale(.6);'/>"+
                "<div class='zoom_in_out_image'>"+
                "<div class='zoom_in_image'>"+
                "<img src='/asset/img/zoom-in-button.png' onclick='ZoomIn(event)'>"+
                "</div>"+
                "<div class='zoom_out_image'>"+
                "<img src='/asset/img/zoom-out-button.png' onclick='ZoomOut(event)'>"+
                "</div>"+
                "</div>"+
                "<div class='popup_close_button'></div>"+
                "</div>");

            $(".popup").fadeIn(500);
            $('.popup').css('display', 'flex');

            $(".popup_close_button").click(function(){
                $(".popup").fadeOut(500);
                setTimeout(function() {
                    $(".popup").remove(); }, 800);
            });
        }
        function videoToModal(){
            $("body").append("<div class='popup'>"+
                "<div class='popup_bg'></div>"+
                "<video  width='120' height='140' class='popup_video' controls>"+
                "<source src=" + videoSrc + ">"+
                "</video>"+
                "<div class='popup_close_button'></div>"+
                "</div>");

            $(".popup").fadeIn(500);
            $('.popup').css('display', 'flex');

            $(".popup_close_button").click(function(){
                $(".popup").fadeOut(500);
                setTimeout(function() {
                    $(".popup").remove(); }, 800);
            });
        }
        function ZoomIn(e){
            let matrixRegex = /matrix\((-?\d*\.?\d+),\s*0,\s*0,\s*(-?\d*\.?\d+),\s*0,\s*0\)/,
                matches = $('.popup_img').css('transform').match(matrixRegex);

            let scaleValue = parseFloat(matches[1]);
            if(scaleValue < 5.1){
                let result =  scaleValue + 0.3;
                $('.popup_img').css('transform', 'scale(' + result + ')' );
            }
        }
        function ZoomOut(e){
            let matrixRegex = /matrix\((-?\d*\.?\d+),\s*0,\s*0,\s*(-?\d*\.?\d+),\s*0,\s*0\)/,
                matches = $('.popup_img').css('transform').match(matrixRegex);

            let scaleValue = parseFloat(matches[1]);
            if(scaleValue >= 0.6){
                let result =  scaleValue - 0.3;
                $('.popup_img').css('transform', 'scale(' + result + ')' );
            }
        }
        function FileExtension(name) {
            var m = name.match(/\.([^.]+)$/)
            return m && m[1]
        }
    </script>
@endpush
