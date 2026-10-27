<?php

include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/sicurezza/sessioni/SessioneProtetta.php";
include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/utility/DescrittoreClasse.php";
protetta_session_start(); // avvio un SessioneProtetta

$IdDescrittore = $_GET['DescrittoreClasse'];
$IdAzienda = $_SESSION['IdAzienda'];
$keyDescrittore = $IdAzienda . KeyHelper::KEY_SEPARATOR . $IdDescrittore;

$descrittore = DescrittoreClasse::elementWithKey($keyDescrittore);

$select = $descrittore->getSelect();
$where = " WHERE ";
if (! $descrittore->getVisibilityMulti()) {
    $where .= " ID_AZIENDA = '" . $IdAzienda . "' ";
}

if (strlen($where) > 7) { // se ho aggiunto parametri alla where la aggiungo alla select
    $select .= $where;
}

?>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<!-- Favicons -->
<link href="<?php echo $_SESSION['webAppPath']?>/assets/img/favicon.png"
	rel="icon">
<link
	href="<?php echo $_SESSION['webAppPath']?>/assets/img/apple-touch-icon.jpg"
	rel="apple-touch-icon">

<link
	href="<?php echo $_SESSION['webAppPath']?>/assets/vendor/bootstrap/css/bootstrap.min.css"
	rel="stylesheet">

<link
	href="<?php echo $_SESSION['webAppPath']?>/assets/css/mainGrid.css"
	rel="stylesheet">
</head>
<body>
	<form action="<?php echo "\\CadTimbratore/area-riservata/".$descrittore->getGridActionAdapter() ?>" method="POST" target="actionsFrame">
	
		<input type="hidden" name="IdAzienda" value="<?php echo $IdAzienda ?>">
		<input type="hidden" name="IdDescrittore" value="<?php echo $IdDescrittore ?>">
		<input type="hidden" name="businessClass" value="<?php echo $descrittore->getBusinessClass() ?>">
		<input type="hidden" name="tableName" value="<?php echo $descrittore->getTableName() ?>">
		<input type="hidden" name="formName" value="<?php echo $descrittore->getFormName() ?>">
		

		<div class="container-fluid">
		<?php require 'toolBarGrid.php'; ?>
			<div class="table-responsive custom-table-responsive">
				<table class="table custom-table">
					<thead>
						<tr>
							<th scope="col"><label class="control control--checkbox"> <input
									type="checkbox" class="js-check-all" />
									<div class="control__indicator"></div>
							</label></th>

						<?php
                            foreach ($descrittore->getAttributi() as $att) {
                                echo "<th>" . $att->getDescrizione() . "</th>";
                            }
                        ?>
					</tr>
					</thead>

					<tbody>				
    				<?php
                        include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/src/it/caddit/base/connessioni/database/ConnessioneDB.php";
                        $table = mysqli_query($mysqli, $select);
                    
                        while ($row = mysqli_fetch_array($table)) {
                            $colonneChiave = $descrittore->retrieveColonneKey();
                            $i = 0;
                            $key = "";
                            foreach ($colonneChiave as $cK) {
                                if ($i > 0)
                                    $key .= KeyHelper::KEY_SEPARATOR;
                                $key .= $row[$cK];
                                $i ++;
                            }
                            
                            $form = "/CadTimbratore/area-riservata/";                            
                            $form .= "\\\\" . str_replace("\\", "\\\\", $descrittore->getFormName()) . "?";
                            $params = "Key=" . $key . "&Mode=UPDATE";
                            $form .= $params;                
                    ?>
					<tr scope="row">
							<th scope="row"><label class="control control--checkbox"> 
								<input type="checkbox" name="recordGriglia[]" value="<?php echo $key; ?>" />
									<div class="control__indicator"></div>
							</label></th>
    				<?php
                        foreach ($descrittore->getAttributi() as $att) {
                            echo "<td onclick=\"window.open('".$form."','Caddit','width=900px,height=600px')\" class=\"".$att->getIdAttributo()."\">" . $row[$att->getColumnName()] . "</td>";
                        }
                    ?>
        			</tr>
						<tr class="spacer">
							<td colspan="100"></td>
						</tr>
    				<?php
                        }
                    ?>
    				</tbody>
				</table>
			</div>
		</div>
	</form>
	
	<?php if($descrittore->getGridModifier() != null)include $_SERVER['DOCUMENT_ROOT'] . "/CadTimbratore/area-riservata/".$descrittore->getGridModifier(); ?>
	<iframe frameborder="0" id="actionsFrame" name="actionsFrame" src="">
	</iframe>
	<script type="text/javascript">


		function c(){
		var checkedValues = [];
		var inputElements = document.getElementsByClassName('recordGriglia');
		for(var i=0; inputElements[i]; ++i){
		      if(inputElements[i].checked){
		           checkedValues.push(inputElements[i].value);
		      }
		}
		console.log(checkedValues);
		}

	</script>
</body>
</html>
