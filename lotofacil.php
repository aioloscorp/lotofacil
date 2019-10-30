<!doctype html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Aioloscorp</title>
  
  	<link rel="stylesheet" type="text/css" href="static/js/easyui/themes/icon.css"/>
    <link rel="stylesheet" type="text/css" href="static/js/easyui/themes/default/easyui.css"/>
    <link rel="stylesheet" type="text/css" href="static/js/zTree/zTreeStyle/zTreeStyle.css"/>
    <script type="text/javascript" src="static/js/jquery.min.js"></script>
    <script type="text/javascript" src="static/js/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="static/js/zTree/jquery.ztree.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ultra" />
    <link rel="icon" href="favicon.ico">
    <style>
    	
    	.icon-concurso-large{
background:url('static/css/download.png') no-repeat center center;

}
.icon-lotofacil{
background:url('./favicon.png') no-repeat center center;
}


.countdown time {
    font-family: 'ProximaNova-Bold';
    font-size: 36px;
    color: #fc0;
    padding: 5px;
    display: block;
    white-space: nowrap;
}

    </style>
    
</head>
<script type="text/javascript">
<?php 
/**
* Função para calcular o próximo dia útil de uma data
* Formato de entrada da $data: AAAA-MM-DD
*/
function proximoDiaUtil($data, $saida = 'd/m/Y') {
// Converte $data em um UNIX TIMESTAMP
$timestamp = strtotime($data);
// Calcula qual o dia da semana de $data
// O resultado será um valor numérico:
// 1 -> Segunda ... 7 -> Domingo
$dia = date('N', $timestamp);
// Se for sábado (6) ou domingo (7), calcula a próxima segunda-feira
if ($dia >= 6) {
$timestamp_final = $timestamp + ((8 - $dia) * 3600 * 24);
} else if ($dia == 2) {
$timestamp_final = $timestamp + ((4 - $dia) * 3600 * 24);
} elseif ($dia == 4){
$timestamp_final = $timestamp + ((6 - $dia) * 3600 * 24);	
}else{
	$timestamp_final = $timestamp;	
}
return date($saida, $timestamp_final);
}






$data1=date("Y-m-d");
//$data = '2018-12-20';
$data_final = proximoDiaUtil($data1, 'Y-m-d');

$datahora = $data_final;




$status = $dados['status'];
//$datahora = '2018-12-24';
list($data, $hora) = explode(' ', $datahora);
list($ano, $mes, $dia) = explode('-', $data);
list($hora, $minuto, $segundo) = explode(':', $hora);
?>

var YY = "<?php echo $ano;?>";
var MM = "<?php echo $mes;?>";
var DD = "<?php echo $dia;?>";
var HH = "<?php echo $hora;?>";
var MI = "<?php echo $minuto;?>";
var SS = "<?php echo $segundo;?>";
var STS = "<?php echo $status;?>";

function atualizaContador() {
 $.post("view/php/derado/data.php",function(data){
 var dataatual = data;

 var hoje = new Date(dataatual.split("/")[0],dataatual.split("/")[1]-1,dataatual.split("/")[2],dataatual.split("/")[3],dataatual.split("/")[4],dataatual.split("/")[5]);
 var futuro = new Date(YY,MM-1,DD,HH,MI,SS);

 var ss = parseInt((futuro - hoje) / 1000);
 var mm = parseInt(ss / 60);
 var hh = parseInt(mm / 60);
 var dd = parseInt(hh / 24);

 ss = ss - (mm * 60);
 mm = mm - (hh * 60);
 hh = hh - (dd * 24);

 var faltam = '';
 faltam += (dd && dd > 1) ? dd+'dias, ' : (dd==1 ? '1 dia, ' : '');
 faltam += (toString(hh).length) ? hh+'h, ' : '';
 faltam += (toString(mm).length) ? mm+'m e ' : '';
 faltam += ss+'s';

 if (STS == 'e'){
 document.getElementById('contador').innerHTML = 'Encerrada';
 }
 else {
    if (dd+hh+mm+ss > 0) {
    document.getElementById('contador').innerHTML = faltam;
    setTimeout(atualizaContador,1000);
    }
    else {
 document.getElementById('contador').innerHTML = 'Encerrada';
 //location.href="php/alterarstatus.php?id=<?php echo $id?>";
    }
 }
})
}		
</script>
<body class="easyui-layout" onload="atualizaContador();">
<div data-options="region:'north',border:false" style="height: 60px; padding: 10px; background-color: #a55392">
   
   <table>
<tbody>
<tr>
<td><img src="LOTFACIL.GIF" alt="" /></td>
<td><div style=" font-family: 'ultra';
    font-size: 36px;
    color: #3abe14;
    padding: 5px;
    display: block;
    white-space: nowrap;">Proximo Sorteio:</div></td>
<td>
    <span id='contador' class="countdown" style=" font-family: 'ultra';
    font-size: 36px;
    color: #fc0;
    padding: 5px;
    display: block;
    white-space: nowrap;"></span></td>
</tr>
</tbody>
</table>
   
   

</div>
<div data-options="region:'west',split:true,title:'Menu'" style="width: 150px; padding: 10px;">
    <ul id="webMenu_list" class="ztree" style="display: ;">
    </ul>
</div>
<div data-options="region:'center',title:'',border:false">
    <div id="tt" class="easyui-tabs" data-options="fit:true">
        <div id="inicio" title="Lotofacil" style="padding: 20px;">
         <!--codigo inicio-->
         

<script type="text/javascript">
var url;		
function newUser(){$('#dlg').dialog('open').dialog('setTitle','Novo Concurso');
$('#fm').form('clear');
url = 'php/salvar_cadastroConcurso.php';
}
function editUser(){
	var row = $('#dg').datagrid('getSelected');
				if (row){$('#dlg').dialog('open').dialog('setTitle','Editar Concurso');
$('#fm').form('load',row);
url = 'atualizar_cadastroConcurso.php?id='+row.id;
}}
function saveUser(){$('#fm').form('submit',{url: url,onSubmit: function(){
return $(this).form('validate');
},
success: function(result){var result = eval('('+result+')');
if (result.success){$('#dlg').dialog('close');		/* close the dialog*/
$('#dg').datagrid('reload');	/*/ reload the user data*/
} else {
	$.messager.show({title: 'Erro',
msg: result.msg});
}}});
}		
function removeUser(){var row = $('#dg').datagrid('getSelected');
if (row){$.messager.confirm('Confirm','Tem certeza que deseja remover o Concurso?',function(r){if (r){$.post('view/remover_cadastroConcurso.php',
{
	id:row.id},function(result){if (result.success){$('#dg').datagrid('reload');	/*/ reload the user data*/} else {$.messager.show({	/* show error message*/title: 'Error',									msg: result.msg});}},'json');}});}}</script>
   <table id="dg" title="AiolosCorp - Cadastro de Concurso " class="easyui-datagrid" fit="true" url="view/pegar_cadastroConcurso.php"	toolbar="#toolbar" pagination="true"rownumbers="true" fitColumns="true" singleSelect="true" style="width:auto;height:auto" >
      <thead>
         <tr>
            <th field="Concurso" width="35" sortable="true" >Concurso</th>
            <th field="Data_Sorteio" width="50" sortable="true" >Data Sorteio</th>
            <th field="Bola1" width="50" data-options="field:'Bola1',styler:cellStyler" >Bola1</th>
            <th field="Bola2" width="50" data-options="field:'Bola2',styler:cellStyler"  >Bola2</th>
            <th field="Bola3" width="50" data-options="field:'Bola3',styler:cellStyler"  >Bola3</th>
            <th field="Bola4" width="50" data-options="field:'Bola4',styler:cellStyler"  >Bola4</th>
            <th field="Bola5" width="50" data-options="field:'Bola5',styler:cellStyler"  >Bola5</th>
            <th field="Bola6" width="50" data-options="field:'Bola6',styler:cellStyler"  >Bola6</th>
            <th field="Bola7" width="50" data-options="field:'Bola7',styler:cellStyler"  >Bola7</th>
            <th field="Bola8" width="50" data-options="field:'Bola8',styler:cellStyler"  >Bola8</th>
            <th field="Bola9" width="50" data-options="field:'Bola9',styler:cellStyler"  >Bola9</th>
            <th field="Bola10" width="50" data-options="field:'Bola10',styler:cellStyler"  >Bola10</th>
            <th field="Bola11" width="50" data-options="field:'Bola11',styler:cellStyler"  >Bola11</th>
            <th field="Bola12" width="50" data-options="field:'Bola12',styler:cellStyler"  >Bola12</th>
            <th field="Bola13" width="50" data-options="field:'Bola13',styler:cellStyler"  >Bola13</th>
            <th field="Bola14" width="50" data-options="field:'Bola14',styler:cellStyler"  >Bola14</th>
            <th field="Bola15" width="50" data-options="field:'Bola15',styler:cellStyler"  >Bola15</th>
           
         </tr>
      </thead>
   </table>	<div id="toolbar"><a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()" title="Adicionar Concurso">Novo Concurso</a>		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()" title="Alterar Dados doConcurso">Editar Concurso</a><a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeUser()" title="Remover Dados doConcurso">Remover Concurso</a>

<a href="http://www1.caixa.gov.br/loterias/_arquivos/loterias/D_lotfac.zip" class="easyui-linkbutton" iconCls="icon-concurso-large" plain="true"  title="Baixar Resultados">Baixar Resultados</a>


<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">updaterow</a>



<form enctype="multipart/form-data" id="ff" name="ff" method="post">
            <table border="0" style="width:100%">
                <tr>
                    <td>
                    
                    <input id="fb" name="arquivo" type="text" style="width: 100%;"></td>
                    <td style="width: 90px; text-align: right;"><a id="btn-upload" href="javascript:void(0)">Atualizar</a></td>
                   
                </tr>
            </table>
</form>
<div id="multiusage"></div>
<script type="text/javascript">
$(function() {

	$('#fb').filebox({
        buttonText: 'Carregar...',
        multiple: true,
        icons:[{
            iconCls:'icon-clear',
            handler: function(e){
                $(e.data.target).filebox('clear');
            }
        }],
        onChange: function (newValue, oldValue) {
            if ($(this).textbox('getValue').length > 0 ) {
                $('#btn-upload').linkbutton('enable');
            }
            else { $('#btn-upload').linkbutton('disable'); }
        }
    });
    var inputfile = $('#fb').next().find('.textbox-value');
    $('#btn-upload').linkbutton({
        iconCls: 'icon-upload', disabled: true, plain: true,
        onClick: function() { upLoad(); }
    });
    
    // Function to execute on submit form
    function upLoad() {
        if ($('#fb').textbox('getValue').length === 0) {
            $.messager.alert('Message','Upload not possible.<br /><br />Nada foi selecionado.','error');
            return false;
        }
        $('#ff').form('submit', {
            url: 'view/atualiza/carrega.php',
            queryParams: { uploadpath: 'temp' },
            iframe: false,
            onProgress: function (percent) {
                progressFile('update',percent);
            },
            onSubmit: function(param) {
                progressFile('show');
            },
            success: function(data) {
                $('ff').form('clear');
                setTimeout(function() {
                    submitReturn(data,function(data) { // nothing to exec on submit success                       
                    },
                    function(){ // nothing to exec on submit error
                    },false);
                },1000); }
		});
    }
	
	// Show modal ProgrssBar when uploading file
	function progressFile(method,val){
		var div_id='win-progress-file';
		var progress_id='progress-file';
		var htmlcontent = '<div id="'+progress_id+'" class="easyui-progressbar" style="width:100%;"></div>' +
			'<div style="margin-top: 10px; text-align: center; font-size: 1.3em; font-weight: bold;">Atualizando Resultados </br> Aguarde essa janela fechar</div>';
		var op = method.toLowerCase();
		switch (op) {
			case 'show':
				$("#multiusage").append('<div id="'+div_id+'" style="padding: 20px;"></div>');
				$("#"+div_id).window({
						title: 'Aguarde ...',
						width: 300,
						resizable: false, shadow: false,
						minimizable: false, maximizable: false, collapsible:false, closable: false,
						modal: true,
						onClose: function (event, ui) {
								$("#"+div_id).window('destroy');
								$("#"+div_id).remove();
						},
						content: htmlcontent
				});
			break;
			case 'close':
				$("#"+div_id).window('close');
			break;
			case 'update':
				$("#"+progress_id).progressbar('setValue', val);
				
			
				
			break;

		}
	}

	//Manage form submit return message (you can optionally exec specified function on success and on error)
	function submitReturn(data,successCallback,errorCallback,showSavemsg) { 
		showSavemsg = typeof showSavemsg !== 'undefined' ? showSavemsg : true;
		$.messager.progress('close');
		progressFile('close');
		try {
			var data = $.parseJSON(data);
		} catch (e) {
	//        console.log(e);
			$.messager.alert('Sucesso',data);
			 $('fb').form('clear');
			errorCallback();
			return false;
		}
		if (data.error === true){
			$.messager.alert('Server Error',data.message,'error');
			errorCallback(data);
			return false;
		} else {
			if (showSavemsg) {
				$.messager.show({
					title:'Message',
					msg:'<span class="icon-ok"><img src="img/blank.gif" width="22" height="16"></span><span>Data successfully saved.</span>'
				});
			}
			successCallback(data);
		}
	}	
 
});

$('#dd').dialog({closable: false,
	
    title: 'Verificando Tabelas - Aguarde',
    width: 400,
    height: 200,
    closed: false,
    cache: false,
    href: 'view/php/tabelas/somatab.php',
    modal: true
});

$('#conta2').dialog({closable: false,
    title: 'Verificando Tabelas - Aguarde',
    width: 400,
    height: 200,
    closed: false,
    cache: false,
    href: 'view/php/tabelas/contaultimos(2).php',
    modal: true
});
$('#conta3').dialog({closable: false,
    title: 'Verificando Tabelas - Aguarde',
    width: 400,
    height: 200,
    closed: false,
    cache: false,
     href: 'view/php/tabelas/contaultimos(3).php',
    modal: true
});
$('#conta4').dialog({closable: false,
    title: 'Verificando Tabelas - Aguarde',
    width: 400,
    height: 200,
    closed: false,
    cache: false,
     href: 'view/php/tabelas/contaultimos(4).php',
    modal: true
});
$('#conta5').dialog({closable: false,
    title: 'Verificando Tabelas - Aguarde',
    width: 400,
    height: 200,
    closed: false,
    cache: false,
    href: 'view/php/tabelas/contaultimos(5).php',
    modal: true
});
$('#conta6').dialog({closable: false,
    title: 'Verificando Tabelas - Aguarde',
    width: 400,
    height: 200,
    closed: false,
    cache: false,
    href: 'view/php/tabelas/contaultimos(6).php',
    modal: true
});
$('#conta7').dialog({closable: false,
    title: 'Verificando Tabelas - Aguarde',
    width: 400,
    height: 200,
    closed: false,
    cache: false,
   href: 'view/php/tabelas/contaultimos(7).php',
    modal: true
});
$('#contar').dialog({closable: false,
    title: 'Verificando Tabelas - Aguarde',
    width: 400,
    height: 200,
    closed: false,
    cache: false,
    href: 'view/php/tabelas/contar.php',
    modal: true
});

$('#conta10').dialog({closable: false,
    title: 'Verificando Tabelas - Aguarde',
    width: 400,
    height: 200,
    closed: false,
    cache: false,
    href: 'view/php/tabelas/contaultimos(10).php',
    modal: true
});
$('#dd').dialog('refresh', 'view/php/tabelas/somatab.php');
$('#contar').dialog('refresh', 'view/php/tabelas/contar.php');
$('#conta2').dialog('refresh', 'view/php/tabelas/contaultimos(2).php');
$('#conta3').dialog('refresh', 'view/php/tabelas/contaultimos(3).php');
$('#conta4').dialog('refresh', 'view/php/tabelas/contaultimos(4).php');
$('#conta5').dialog('refresh', 'view/php/tabelas/contaultimos(5).php');
$('#conta6').dialog('refresh', 'view/php/tabelas/contaultimos(6).php');
$('#conta7').dialog('refresh', 'view/php/tabelas/contaultimos(7).php');
$('#conta10').dialog('refresh', 'view/php/tabelas/contaultimos(10).php');

function cellStyler(value,row,index){
            if (value == 1){
                return 'background-color:#ff0000;';
            }
            else if (value == 2 ){	
					return 'background-color:#fe7301;font-weight:bold'; //'background-color:#f6ced8';
					}
				 else if (value == 3 ){
					return 'background-color:#febf01;font-weight:bold'; //'background-color:#f6ced8';
					} else if (value == 4 ){	
					return 'background-color:#fef801;font-weight:bold'; //'background-color:#f6ced8';
					}
				 else if (value == 5 ){
					return 'background-color:#b3fe01;font-weight:bold'; //'background-color:#f6ced8';
					} else if (value == 6 ){	
					return 'background-color:#02fd09;font-weight:bold'; //'background-color:#f6ced8';
					}
				 else if (value == 7 ){
					return 'background-color:#01feb3;font-weight:bold'; //'background-color:#f6ced8';
					} else if (value == 8 ){	
					return 'background-color:#01cbfe;font-weight:bold'; //'background-color:#f6ced8';
					}
				 else if (value == 9 ){
					return 'background-color:#01a6fe;font-weight:bold'; //'background-color:#f6ced8';
					} else if (value == 10 ){	
					return 'background-color:#4101fe;font-weight:bold'; //'background-color:#f6ced8';
					}
				 else if (value == 11 ){
					return 'background-color:#9302fd;font-weight:bold'; //'background-color:#f6ced8';
					} else if (value == 12 ){	
					return 'background-color:#fd02fd;font-weight:bold'; //'background-color:#f6ced8';
					}
				 else if (value == 13 ){
					return 'background-color:#fe0153;font-weight:bold'; //'background-color:#f6ced8';
					} else if (value == 14 ){	
					return 'background-color:pink;font-weight:bold'; //'background-color:#f6ced8';
					}
				 else if (value == 15 ){
					return 'background-color:#cb4734;font-weight:bold'; //'background-color:#f6ced8';
					} else if (value == 16 ){	
					return 'background-color:#c0ad3f;font-weight:bold'; //'background-color:#f6ced8';
					}
				 else if (value == 17 ){
					return 'background-color:#82b34d;font-weight:bold'; //'background-color:#f6ced8';
					} else if (value == 18 ){	
					return 'background-color:#55aa55;font-weight:bold'; //'background-color:#f6ced8';
					}
				 else if (value == 19 ){
					return 'background-color:#4eb19d;font-weight:bold'; //'background-color:#f6ced8';
					} else if (value == 20 ){	
					return 'background-color:#5579aa;font-weight:bold'; //'background-color:#f6ced8';
					}
				 else if (value == 21 ){
					return 'background-color:#ab54a9;font-weight:bold'; //'background-color:#f6ced8';
					}else if (value == 22 ){
					return 'background-color:#9f6093;font-weight:bold'; //'background-color:#f6ced8';
					}else if (value == 23 ){
					return 'background-color:#44bba9;font-weight:bold'; //'background-color:#f6ced8';
					}else if (value == 24 ){
					return 'background-color:#b946a2;font-weight:bold'; //'background-color:#f6ced8';
					}else if (value == 25 ){
					return 'background-color:#966971;font-weight:bold'; //'background-color:#f6ced8';
					}
        }

</script>




<div id="dd" class="easyui-dialog" title="Verificando Tabelas - Aguarde" style="width:400px;height:200px;"
        data-options="iconCls:'icon-lotofacil',resizable:true, closed: false,modal:true">
    
</div>

<div id="contar" class="easyui-dialog" title="Verificando Tabelas - Aguarde" style="width:400px;height:200px;"
        data-options="iconCls:'icon-lotofacil',resizable:true, closed: false,modal:true">
    
</div>

<div id="conta2" class="easyui-dialog" title="Verificando Tabelas - Aguarde" style="width:400px;height:200px;"
        data-options="iconCls:'icon-lotofacil',resizable:true, closed: false,modal:true">
    
</div>
<div id="conta3" class="easyui-dialog" title="Verificando Tabelas - Aguarde" style="width:400px;height:200px;"
        data-options="iconCls:'icon-lotofacil',resizable:true, closed: false,modal:true">
    
</div>
<div id="conta4" class="easyui-dialog" title="Verificando Tabelas - Aguarde" style="width:400px;height:200px;"
        data-options="iconCls:'icon-lotofacil',resizable:true, closed: false,modal:true">
    
</div>
<div id="conta5" class="easyui-dialog" title="Verificando Tabelas - Aguarde" style="width:400px;height:200px;"
        data-options="iconCls:'icon-lotofacil',resizable:true, closed: false,modal:true">
    
</div>
<div id="conta6" class="easyui-dialog" title="Verificando Tabelas - Aguarde" style="width:400px;height:200px;"
        data-options="iconCls:'icon-lotofacil',resizable:true, closed: false,modal:true">
    
</div>
<div id="conta7" class="easyui-dialog" title="Verificando Tabelas - Aguarde" style="width:400px;height:200px;"
        data-options="iconCls:'icon-lotofacil',resizable:true, closed: false,modal:true">
    
</div>
<div id="conta10" class="easyui-dialog" title="Verificando Tabelas - Aguarde" style="width:400px;height:200px;"
        data-options="iconCls:'icon-lotofacil',resizable:true, closed: false,modal:true">
    
</div>

<div id="dlgUDOMshow" class="easyui-dialog" style="width:425px;height:500px;padding:10px;" data-options="modal:true,closed:true,cache:false"></div>
<script>function destroyUser(){
	$('#dlgUDOMshow').dialog({
	closed:false,
	iconCls:'icon-list-m1-edit',
	title:'&nbsp;Lihat Unlisted Domain',
	href:'view/php/tabelas/conta10.php',
	onLoad:function(){
		$('#fmUDOMshow').form('load',row);
	}
});
}</script>

</div>	<div id="dlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"closed="true" buttons="#dlg-buttons">
   <div class="ftitle">Dados do Concurso</div>
   <form id="fm" method="post" novalidate>
      <div class="fitem"><label>Concurso:</label><input name="Concurso" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Data_Sorteio:</label><input name="Data_Sorteio" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Bola1:</label><input name="Bola1" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Bola2:</label><input name="Bola2" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Bola3:</label><input name="Bola3" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Bola4:</label><input name="Bola4" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Bola5:</label><input name="Bola5" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Bola6:</label><input name="Bola6" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Bola7:</label><input name="Bola7" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Bola8:</label><input name="Bola8" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Bola9:</label><input name="Bola9" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Bola10:</label><input name="Bola10" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Bola11:</label><input name="Bola11" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Bola12:</label><input name="Bola12" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Bola13:</label><input name="Bola13" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Bola14:</label><input name="Bola14" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Bola15:</label><input name="Bola15" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Arrecadacao_Total:</label><input name="Arrecadacao_Total" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Ganhadores_15_Numeros:</label><input name="Ganhadores_15_Numeros" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Cidade:</label><input name="Cidade" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>UF:</label><input name="UF" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Ganhadores_14_Numeros:</label><input name="Ganhadores_14_Numeros" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Ganhadores_13_Numeros:</label><input name="Ganhadores_13_Numeros" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Ganhadores_12_Numeros:</label><input name="Ganhadores_12_Numeros" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Ganhadores_11_Numeros:</label><input name="Ganhadores_11_Numeros" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Valor_Rateio_15_Numeros:</label><input name="Valor_Rateio_15_Numeros" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Valor_Rateio_14_Numeros:</label><input name="Valor_Rateio_14_Numeros" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Valor_Rateio_13_Numeros:</label><input name="Valor_Rateio_13_Numeros" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Valor_Rateio_12_Numeros:</label><input name="Valor_Rateio_12_Numeros" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Valor_Rateio_11_Numeros:</label><input name="Valor_Rateio_11_Numeros" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Acumulado_15_Numeros:</label><input name="Acumulado_15_Numeros" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Estimativa_Premio:</label><input name="Estimativa_Premio" class="easyui-validatebox" required="true"></div>
      <div class="fitem"><label>Valor_Acumulado_Especial:</label><input name="Valor_Acumulado_Especial" class="easyui-validatebox" required="true"></div>
   </form>
</div>
<div id="dlg-buttons"><a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveUser()">Salvar</a>		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a></div>
</body></html>
         <!--codigo fim inicio-->
        </div>
    </div>
</div>
<div id="mm" class="easyui-menu" style="width:120px;">
    <div id="mm-tabclosrefresh" data-options="name:6">Atualiza</div>
    <div id="mm-tabclose" data-options="name:1">Close</div>
    <div id="mm-tabcloseall" data-options="name:2">Close All</div>
    <div id="mm-tabcloseother" data-options="name:3">Close all Tabs</div>
    <div class="menu-sep"></div>
    <div id="mm-tabcloseright" data-options="name:4">Close Right</div>
    <div id="mm-tabcloseleft" data-options="name:5">Close Left</div>
</div>



      
<script type="text/javascript">

     
    //添加Tabs
    function addTabs(event, treeId, treeNode, clickFlag) {
        if (!$("#tt").tabs('exists', treeNode.name)) {
            $('#tt').tabs('add', {
                id: treeId,
                title: treeNode.name,
                selected: true,
                href: treeNode.dataurl,
                closable: true
            });
        } else $('#tt').tabs('select', treeNode.name);
    }

    //删除Tabs
    function closeTab(menu, type) {
        var allTabs = $("#tt").tabs('tabs');
        var allTabtitle = [];
        $.each(allTabs, function (i, n) {
            var opt = $(n).panel('options');
            if (opt.closable)
                allTabtitle.push(opt.title);
        });
        var curTabTitle = $(menu).data("tabTitle");
        var curTabIndex = $("#tt").tabs("getTabIndex", $("#tt").tabs("getTab", curTabTitle));
        switch (type) {
            case 1:
                $("#tt").tabs("close", curTabIndex);
                return false;
                break;
            case 2:
                for (var i = 0; i < allTabtitle.length; i++) {
                    $('#tt').tabs('close', allTabtitle[i]);
                }
                break;
            case 3:
                for (var i = 0; i < allTabtitle.length; i++) {
                    if (curTabTitle != allTabtitle[i])
                        $('#tt').tabs('close', allTabtitle[i]);
                }
                $('#tt').tabs('select', curTabTitle);
                break;
            case 4:
                for (var i = curTabIndex; i < allTabtitle.length; i++) {
                    $('#tt').tabs('close', allTabtitle[i]);
                }
                $('#tt').tabs('select', curTabTitle);
                break;
            case 5:
                for (var i = 0; i < curTabIndex-1; i++) {
                    $('#tt').tabs('close', allTabtitle[i]);
                }
                $('#tt').tabs('select', curTabTitle);
                break;
            case 6: //刷新
                var panel = $("#tt").tabs("getTab", curTabTitle).panel("refresh");
                break;
        }
    }

    $(document).ready(function () {
        //监听右键事件，创建右键菜单
        $('#tt').tabs({
            onContextMenu: function (e, title, index) {
                e.preventDefault();
                if (index > 0) {
                    $('#mm').menu('show', {
                        left: e.pageX,
                        top: e.pageY
                    }).data("tabTitle", title);
                }
            }
        });
        //右键菜单click
        $("#mm").menu({
            onClick: function (item) {
                closeTab(this, item.name);
            }
        });
        //treeNodes
        var zNodes = [
                   
          
            
              {id: 1, pId: 2, name: "Somatoria", dataurl: "view/php/tabelas/somatoria.php", target: "_self"},
            {id: 2, pId: 3, name: "Confere", dataurl: "view/php/confere.php", target: "_self"},
               {id: 3, pId: 4, name: "Estatica", url: "view/php/estatistica/est.php", target: "_blank"},
               {id: 5, pId: 5, name: "Melhor2Ultimos", dataurl: "view/php/melhor2ultimos/index.php", target: "_self"},
               {id: 6, pId: 6, name: "Provaveis", dataurl: "view/php/provaveis/index.php", target: "_self"},
            {id: 4, pId: 5, name: "O que Deu", url: "view/php/derado/index.php", target: "_blank"}
            
            
        ];

        var setting = {
            view: {
                selectedMulti: false
            },
            callback: {
                onClick: addTabs
            }
        };

        $.fn.zTree.init($("#webMenu_list"), setting, zNodes);

    });
    
    
    
    
</script>
</body>
</html>
