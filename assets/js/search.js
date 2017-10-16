function search(table, param, destiny, modal)
{
	$.ajax({
		url: "../../"+table+"/search",
		type: "POST",
		dataType: "json",
		data: JSON.parse(JSON.stringify(param)),
		success:function(data)
		{
			$('#'+destiny).children().remove();
			$('#'+destiny).append($('<option>',{ value: '', text: '-'}));
			for (var i=0;i<data.num;i++) {
				$('#'+destiny).append($('<option>',{
					value: data.data[i].id,
					text: data.data[i].nome
				}));
			}
			$('#'+modal).modal('toggle');
		}
	});
}
function searchInstrutor(table, param, destiny, modal)
{
	$.ajax({
		url: "../../"+table+"/searchInstrutor",
		type: "POST",
		dataType: "json",
		data: JSON.parse(JSON.stringify(param)),
		success:function(data)
		{
			$('#'+destiny).children().remove();
			$('#'+destiny).append($('<option>',{ value: '', text: '-'}));
			for (var i=0;i<data.num;i++) {
				$('#'+destiny).append($('<option>',{
					value: data.data[i].id,
					text: data.data[i].nome
				}));
			}
			$('#'+modal).modal('toggle');
		}
	});
}
function searchLote(table, param, destiny, modal)
{
	$.ajax({
		url: "../../"+table+"/search",
		type: "POST",
		dataType: "json",
		data: JSON.parse(JSON.stringify(param)),
		success:function(data)
		{
			$('#'+destiny).children().remove();
			$('#'+destiny).append($('<option>',{ value: '', text: '-'}));
			for (var i=0;i<data.num;i++) {
				$('#'+destiny).append($('<option>',{
					value: data.data[i].id,
					text: data.data[i].id
				}));
			}
			if (modal) { $('#'+modal).modal('toggle'); }
		}
	});
}
function getQtdLote(table, param, destiny)
{
	$.ajax({
		url:"../../"+table+"/search",
		type: "POST",
		dataType: "json",
		data: JSON.parse(JSON.stringify(param)),
		success:function(data)
		{
			$('#'+destiny).val("");
			$('#'+destiny).attr('max', 0);
			for (var i=0;i<data.num;i++) {
				$('#'+destiny).attr('max', data.data[i].quantidade);
				break;
			}
		}
	});
}