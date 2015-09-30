@extends('app')

@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">Importador de Notas fiscais eletrônicas</div>
                    <div class="panel-body">
                        <h4>Importe suas notas fiscais de entrada e saída:</h4>
                        <p>Ao efetuar a importação, compras, vendas, clientes, fornecedores e faturas serão carregados no sistema automaticamente.</p>
                        <hr />

                        <input id="file" type="file" class="hidden" multiple="true" class="form-control" />
                        <button id="btnAddFiles" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Adicionar arquivos .xml</button>

                        <br />
                        <br />

                        <table class="table table-condensed table-striped">
                            <thead>
                            <tr>
                                <th width="10">&nbsp;</th>
                                <th width="100">Progresso</th>
                                <th>Arquivo</th>
                                <th>Resultado</th>
                            </tr>
                            </thead>
                            <tbody id="lista">
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(function(){

            var count = 0;
            var files = [];

            $('#btnAddFiles').click(function(){
                $('#file').click();
            });

            $("#file").change(function(e){
                var numFiles = e.currentTarget.files.length;

                for (var i=0; i<numFiles; i++){
                    files[count] = e.currentTarget.files[i];

                    //Add row
                    $("#lista").append(createRow(count, files[count].name));

                    processar(count);

                    count++;
                }
            });

            function processar(key){

                var file = files[key];

                // Set up the request.
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('notafiscal.upload')  }}', true);

                xhr.upload.addEventListener("progress", buildProgress(key), false);
                xhr.onload = buildOnload(key);

                // Create a new FormData object.
                var formData = new FormData();
                formData.append('file', file, file.name);
                formData.append('_token', '{{ csrf_token() }}');

                xhr.send(formData);
            }

            function buildProgress(id){
                return function(evt) {
                    if (evt.lengthComputable) {

                        //Calc percent
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);

                        //div
                        var divProgress = $("#"+id+' > td > div.progress-bar').first();

                        divProgress.css('width', percentComplete+'%');
                        divProgress.html(percentComplete+'%');

                        if (percentComplete === 100)
                            divProgress.removeClass('active');

                    }
                }
            }

            function buildOnload(id){
                return function() {
                    var response = $.parseJSON(this.responseText);

                    var tdMessage = $("#"+id+' > td.message').first();
                    var button = $("#"+id+' > td > button').first();
                    var divProgress = $("#"+id+' > td > div.progress-bar').first();

                    if (response.code === 0)
                        tdMessage.html('<span class="label label-success">'+response.message+'</span>');
                    else
                        tdMessage.html('<span class="label label-danger">'+response.message+'</span>');

                    button.attr('disabled', false);

                    //Set onClick
                    button.unbind();
                    button.click(function(){
                        divProgress.css('width', '0%');
                        divProgress.html('0%');
                        tdMessage.html('Processando..');

                        processar(id);
                    });
                }
            }


            function createRow(id, filename){
                var html = '<tr id="'+id+'">';

                html += '<td><button class="btn btn-info btn-xs" disabled="true"><i class="glyphicon glyphicon-refresh"></i></button></td>';
                html += '<td><div class="progress-bar progress-bar active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div></td>';
                html += '<td class="file">'+filename+'</td>';
                html += '<td class="message">Processando..</td>';
                html += '</tr>'

                return $(html);
            }

        });
    </script>

@endsection
