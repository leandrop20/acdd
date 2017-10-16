<?php
namespace views;

class View
{
	function __construct()
	{
		
	}
	public function callAlert($text, $url = null)
	{
		echo "<div class='modal fade' id='alert' role='dialog'>
			    <div class='modal-dialog modal-sm'>
			      <div class='modal-content panel-warning'>
			        <div class='modal-header'>
			          <button type='button' class='close' data-dismiss='modal' onclick='callAlert();'>&times;</button>
			          <!--<h4 class='modal-title'>Modal Header</h4>-->
			        </div>
			        <div class='modal-body'>
			          <p>".$text."</p>
			        </div>
			        <div class='modal-footer'>
			        	<button type='button' class='btn btn-default' data-dismiss='modal' onclick='callAlert();'>Fechar</button>
			        </div>
			      </div>
			    </div>
			  </div>
			  <script>
			  	$('#alert').modal('show');
			  	function callAlert()
			  	{
			  		var url = '".$url."';
			  		if (url != '') {
			  			redirect(url);
			  		}
			  	}
			  </script>
			  ";
	}
}
?>