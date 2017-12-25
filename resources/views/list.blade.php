<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />

</head>
<body>
	<div class="container">
		<div class="row">

			<div class="col-sm-3">
			</div>

			<div class="col-sm-6">
				<h4>Laravel Ajax List</h4>
				<hr>
				<div>
					<input type="text" name="searchItem" id="searchItem" class="form-control" placeholder="Search Item">
				</div>

				<br/>
				<div class="panel panel-default">

					<div class="panel-heading"> 
					<h4>Item List	
						<span id="addNewItem" class="pull-right" data-toggle="modal" data-target="#myModal">					
							<i class="fa fa-plus-circle" ></i>
						</span>
					</h4>

					</div>

					<div class="panel-body" id="items">
						<ul class="list-group">

							@foreach($items as $item)
							<li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">{{$item->item}}
								<input type="hidden" id="itemId" value="{{$item->id}}">
							</li>
							@endforeach

						</ul> 
					</div>

				</div>
			</div>

			<div class="col-sm-3">   
			</div>

		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="title">Add New Item </h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="id">
					<input type="text" class="form-control" id="addItem" placeholder="Write item name">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" id="delet" data-dismiss="modal" style="display: none;" >Delet</button>
					<button type="button" class="btn btn-info"  id="saveChanges" data-dismiss="modal" style="display: none;">Save Change</button>
					<button type="button" class="btn btn-success" id="addButton" data-dismiss="modal">Add Item </button>
				</div>
			</div>

		</div>
	</div>
	{{csrf_field()}} 
	<!-- Modal -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

	<script>
		$(document).ready(function() {

			$(document).on('click', '.ourItem', function(event) {
				var text = $(this).text();
				var id = $(this).find("#itemId").val();
				var text = $.trim(text);
				$('#title').text('Edit Item');
				$('#addItem').val(text);
				$('#delet').show('400');
				$('#saveChanges').show('400');
				$('#addButton').hide('400');
				$('#id').val(id);
			});

			$(document).on('click', '#addNewItem', function(event) {
				$('#title').text('Add New Item');
				$('#addItem').val("");
				$('#delet').hide('400');
				$('#saveChanges').hide('400');
				$('#addButton').show('400');
			});

			$('#addButton').click(function(event) {
				var text = $('#addItem').val();
				if(text==""){
					alert('Please Enter Your Item');
				}else{
					$.post('list', {'text':text,'_token':$('input[name=_token]').val()}, function(data) {
						$('#items').load(location.href + ' #items')
					});
				}
			});

			$('#delet').click(function(event) {
				var id= $("#id").val();
				$.post('delete', {'id':id,'_token':$('input[name=_token]').val()}, function(data) {
					$('#items').load(location.href + ' #items')
				});
			});

			$('#saveChanges').click(function(event) {
				var id= $("#id").val();
				var updateItem = $.trim($("#addItem").val());
				$.post('update', {'id':id, 'updateItem':updateItem,'_token':$('input[name=_token]').val()}, function(data) {
					$('#items').load(location.href + ' #items')
				});
			});

			$( function() {
				$( "#searchItem" ).autocomplete({
					source: 'http://localhost/lara-ab/search'
				});
			});




		});


	</script>

</body>
</html>