<?php echo buildContainer($bg_connexion); ?>
<?php echo $_SESSION['error_message']; ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h1 class="panel-title">Add a plugin</h1></div>
            <div class="panel-body">
                <div class="alert alert-info" role="note">Make sure the modules folder has 755 or 775 permissions and the cache folder has 775 permissions before installing a plugin.</div>
                <form action="index.php?page=plugins&action=upload" method="post" enctype="multipart/form-data" id="validator" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="plugin-upload" class="col-sm-3 control-label">Plugin archive</label>
                        <div class="col-sm-9"><input type="file" class="form-control" name="upload" id="plugin-upload" /></div>
                    </div>
                    <div class="form-group"><div class="col-sm-offset-3 col-sm-9"><button type="submit" class="btn btn-primary" name="post" value="Upload">Upload plugin</button></div></div>
                    <div class="form-group" id="plugin-upload-progress" style="display:none;">
                        <div class="col-sm-offset-3 col-sm-9">
                            <div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" style="width:0%;">0%</div></div>
                        </div>
                    </div>
                    <div class="form-group" id="plugin-upload-result" style="display:none;"><div class="col-sm-offset-3 col-sm-9"></div></div>
                </form>
                <script type="text/javascript">
                $(function () {
                    var $form = $('#validator'), $bar = $('#plugin-upload-progress .progress-bar'), $btn = $form.find('button[type=submit]');
                    $form.on('submit', function (e) {
                        var file = $('#plugin-upload')[0].files[0];
                        if (!window.FormData || !file) { return; }
                        e.preventDefault();
                        var data = new FormData(this);
                        data.append('post', 'Upload');
                        $btn.prop('disabled', true);
                        $('#plugin-upload-result').hide();
                        $bar.removeClass('progress-bar-danger progress-bar-success').addClass('active').css('width', '0%').text('0%');
                        $('#plugin-upload-progress').slideDown(200);
                        $.ajax({
                            url: this.action, type: 'POST', data: data, processData: false, contentType: false,
                            xhr: function () {
                                var xhr = $.ajaxSettings.xhr();
                                if (xhr.upload) {
                                    xhr.upload.addEventListener('progress', function (ev) {
                                        if (ev.lengthComputable) {
                                            var pct = Math.round(ev.loaded / ev.total * 100);
                                            $bar.css('width', pct + '%').text(pct < 100 ? pct + '%' : 'Installing...');
                                        }
                                    });
                                }
                                return xhr;
                            }
                        }).done(function (html) {
                            var $msg = $('<div>').append($.parseHTML(html)).find('.container-fluid').first();
                            $bar.removeClass('active').addClass('progress-bar-success').css('width', '100%').text('Done');
                            $('#plugin-upload-result').show().children().html($msg.length ? $msg.html() : 'Upload complete.');
                        }).fail(function () {
                            $bar.removeClass('active').addClass('progress-bar-danger').text('Upload failed');
                        }).always(function () { $btn.prop('disabled', false); });
                    });
                });
                </script>
            </div>
        </div>
    </div>
</div>