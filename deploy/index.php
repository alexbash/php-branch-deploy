<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="assets/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/css/style.css" />
		<script src="assets/js/jquery-1.7.1.min.js"></script>
		<script src="assets/js/deploy.js"></script>
	</head>
	<body>
	
		<!-- Clone a Repo -->
		<div id="cloneContainer" class="modal">
			<form id="clone">
				<div class="modal-header">
					<h3>Clone a Repository</h3>
				</div>
				<div class="modal-body">
					<div id="checkoutNotify" class="alert-message success">Branch checked out successfully. Refresh to clone another repository.</div>
					<div class="input-prepend clear">
						<span class="add-on">git@github.com:</span>
						<input type="text" name="repo" id="repo" placeholder="username/repository.git" value="" />
						<div class="loader">Cloning...</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" id="cloneButton" class="btn primary" value="Clone" />
				</div>
			</form>
		</div>
		
		<!-- Display Branches -->
		<div id="branchContainer" class="modal">
			<form id="branch" class="form-stacked">
				<div class="modal-header">
					<h3>Choose a Branch</h3>
				</div>
				<div class="modal-body">
					<div class="clearfix">
						<div class="input">
							<select class="span4" id="branches" name="branches"></select>
            			</div>
					</div>
					<div class="clearfix">
            		<div class="input">
						<input type="text" name="altDir" id="altDir" placeholder="Alternate subdomain" value="" />
            		</div>
            		</div>
				</div>
				<div class="modal-footer">
					<input type="submit" id="checkoutButton" class="btn primary" value="Checkout" />
				</div>
			</form>
		</div>
		
	</body>
</html>