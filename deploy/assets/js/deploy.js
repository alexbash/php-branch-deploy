$(document).ready(function(){	
	
	var directory;
	
	// Clone a repository
	$('#clone').submit(function(event){
		event.preventDefault();
		$('#cloneButton').attr('disabled', 'true');
		$('.loader').show();
		var repo = $('#repo').val();
		$.post("clone.php", { 'repo': repo }, function(data){
			$('.loader').hide();
			directory = data.directory;
			$.each(data.branches, function(i, v){
				$('#branches').append(
					'<option value="' + v + '">' + v + '</option>'
				);
			});
			$('#cloneContainer').hide();
			$('#branchContainer').show();
		}, 'json')
		
		// Error handler - we'll make this nicer soon
		.error(function(output){
			alert(JSON.stringify(output));
		});
	});
	
	// Checkout the branch
	$('#branch').submit(function(event){
		event.preventDefault();
		$('#checkoutButton').attr('disabled', 'true');
		var branch = $('#branches').val(),
			altDir = $('#altDir').val(),
			options = { 'directory': directory, 'branch': branch, 'altDir': altDir };
		$.post("checkout.php", options, function(data){
			$('#branchContainer').hide();
			$('#cloneContainer').show();
			$('#checkoutNotify').show();
		}, 'json')
		
		// Error handler - we'll make this nicer soon
		.error(function(output){
			alert(JSON.stringify(output));
		});
	});
	
});