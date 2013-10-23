$(document).ready(function(){	
	
	var directory;
	
	// Clone a repository
	$('#clone').submit(function(event){
		event.preventDefault();
		$('#cloneButton').attr('disabled', 'true');
		$('.loader').show();
		var repo = $('#repo').val();
        $.ajax({
            url: 'clone.php',
            type: 'post',
            dataType: 'json',
            data: {repo: repo},
            success: function(response, textStatus, jqXHR){
                if(response.status == 200){
                    var data = response.data;
                    $('.loader').hide();
                    directory = data.directory;
                    $.each(data.branches, function(i, v){
                        $('#branches').append(
                            '<option value="' + v + '">' + v + '</option>'
                        );
                    });
                    $('#cloneContainer').hide();
                    $('#branchContainer').show();
                }
                else{
                    errorMessage(response.reason);
                    $('.loader').hide();
                    $('#cloneButton').removeAttr('disabled');
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                errorMessage(textStatus);
            }
        });
	});
	
	// Checkout the branch
	$('#branch').submit(function(event){
		event.preventDefault();
		$('#checkoutButton').attr('disabled', 'true');
        $('#cloneButton').removeAttr('disabled');
		var branch = $('#branches').val(),
			altDir = $('#altDir').val(),
			options = { 'directory': directory, 'branch': branch, 'altDir': altDir };
        $.ajax({
            url: 'checkout.php',
            type: 'post',
            dataType: 'json',
            data: options,
            success: function(response, textStatus, jqXHR){
                if(response.status == 200){
                    infoMessage(response.message);
                    $('#branchContainer').hide();
                    $('#cloneContainer').show();
                    $('#checkoutNotify').show();
                    $('#checkoutButton').removeAttr('disabled');
                }
                else{
                    errorMessage(response.reason);
                    $('#checkoutButton').removeAttr('disabled');
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                errorMessage(textStatus);
            }
        });
	});
	
});

function infoMessage(message){
    $.jGrowl(message, {theme: 'blue', header: 'Information'});
}
function errorMessage(message){
    $.jGrowl(message, {theme: 'red', header: 'Error'});
}