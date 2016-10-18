@extends('layouts.app')
@section('content')
    <script language="javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function frmSubmit(frmObj) {
            //console.log($(frmObj).find("input.number").val());
            $.ajax(frmObj.action,
                    {
                        data: {hisse: $(frmObj).find("input.number").val()},
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if(data)
                                    alert(data);
                            else {

                                bendekiHisse = $(frmObj).parent().parent().children("td.div-bendeki-hisse")[0].firstElementChild;
                                bosHisse = $(frmObj).parent().parent().children("td.div-bos-hisse")[0].firstElementChild;
                                console.log($(frmObj).find("input.submit"));
                                if ($(frmObj).find("input.submit").val() == "Buy")
                                {
                                    $(bendekiHisse).html((parseInt($(bendekiHisse).html()) + parseInt($(frmObj).find("input.number").val())) + "%");
                                    $(bosHisse).html((parseInt($(bosHisse).html()) - parseInt($(frmObj).find("input.number").val())) + "%");
                                }
                                else
                                {
                                    $(bendekiHisse).html((parseInt($(bendekiHisse).html()) - parseInt($(frmObj).find("input.number").val())) + "%");
                                    $(bosHisse).html((parseInt($(bosHisse).html()) + parseInt($(frmObj).find("input.number").val())) + "%");
                                }
                                $(frmObj).parent().parent().children("td.islem").html("Transaction Successful");

                                //buttonObj = $(frmObj).parent().parent().children("td.buttons")[0].firstElementChild;
                                //$(buttonObj).attr("data-max",(parseInt($(bosHisse).html()) - parseInt($(frmObj).find("input.number").val())));
                            }

                        }
                    }
            );
        }
        $(document).ready(function () {
            $(".ajaxify").click(function () {
                if ($(this).attr("data-max") > 0) {
                    var form = new $("<form>");
                    form.attr("action", $(this).attr("data-href"));
                    form.attr("method", "post");
                    form.attr("enctype", "multipart/form-data");
                    form.attr("onsubmit", "frmSubmit(this);return false;");
                    var input = new $("<input>");
                    input.attr("type", "number");
                    input.attr("class", "number");
                    input.attr("placeholder", 0);
                    form.append(input);
                    form.append(" (Max:" + $(this).attr("data-max") + ")");
                    if ($(this).attr("data-href").indexOf("hisseal") > -1)
                        form.append("<input type='submit' class='submit' value = 'Buy'>");
                    else
                        form.append("<input type='submit' class='submit' value = 'Sell'>");
                    $(this).parent().parent().children("td.islem").html(form);
                }
                else {
                    alert("Yeterli hisse yok");
                    $(this).parent().parent().children("td.islem").html("");
                }
            });
        });
    </script>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Stock Market</div>
                    <tr class="panel-body">
                        <table class="table">
                            <tr>
                                <th>User</th>
                                <th>Stock Value</th>
                                <th>Available (%)</th>
                                <th>Owned (%)</th>
                            </tr>
                            @foreach($eksiciler as $eksici)
                                <tr>
                                    <td>{{$eksici->nick}}</td>
                                    <td>{{$eksici->karma}}</td>
                                    <td class="div-bos-hisse">
                                        <div style="display:inline-block;" class="bos-hisse">{{$eksici->boshisse}}%</div>
                                        </td>
                                    <td class="div-bendeki-hisse">

                                        <div style="display:inline-block;" class="bendeki-hisse">
                                            @if($eksici->hissem > 0)
                                                {{$eksici->hissem}}
                                            @else
                                            0
                                            @endif
                                                %
                                        </div></td>
                                    <td class="buttons"><input type="button" value="+" class="ajaxify" href="javascript:;"
                                               data-max="{{$eksici->boshisse ? $eksici->boshisse : 0}}"
                                               data-href="{{ url('/eksici/' . $eksici->id . "/hisseal") }}">
                                        <input type="button" value="-" class="ajaxify" href="javascript:;"
                                               data-max="{{$eksici->hissem ? $eksici->hissem : 0}}"
                                               data-href="{{ url('/eksici/' . $eksici->id . "/hissesat") }}"></td>
                                    <td class="islem"></td>
                                </tr>
                            @endforeach
                        </table>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
