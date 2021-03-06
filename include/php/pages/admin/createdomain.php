<?php

if(Auth::getUser()->isDomainLimited()){
	Router::displayError(403);
}

if(isset($_POST['domain'])){
	$inputDomain = $_POST['domain'];

	if(!empty($inputDomain)){

		$existingDomain = Domain::findWhere(array(Domain::attr('domain'), $inputDomain));

		if(!is_null($existingDomain)){

			Domain::createAndSave(
				array(
					Domain::attr('domain') => $inputDomain,
				)
			);

			// Created domain successfull, redirect to overview
			Router::redirect("admin/listdomains/?created=1");
		}
		else{
			Message::getInstance()->fail("Domain already exists in database.");
		}
	}
	else{
		Message::getInstance()->fail("Empty domain couldn't be created.");
	}
}

?>

<h1>Create new domain</h1>

<?php echo Message::getInstance()->render(); ?>

<div class="buttons">
	<a class="button" href="<?php echo Router::url('admin/listdomains'); ?>">&#10092; Back to domain list</a>
</div>

<form class="form" action="" method="post" autocomplete="off">
	<div class="input-group">
		<label>Domain</label>
		<div class="input">
			<input type="text" name="domain" placeholder="domain.tld" autofocus required/>
		</div>
	</div>

	<div class="buttons">
		<button type="submit" class="button button-primary">Create domain</button>
	</div>
</form>