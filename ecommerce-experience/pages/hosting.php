<h2>Experience Manager Hosting</h2>
<style>
	.exm_level {
		background-color: white;
		color: black;
		border-color: gray;
		border-style: solid;
		border-width: 1px;
		width: 250px;
		padding: 5px;
		margin-bottom: 10px;
		text-align: center;
	}
	.exm_level h3 {
		font-weight: bolder;
	}
</style>
<?php
$parameters = [
	"site" => tma_exm_get_site()];
$request = new TMA\ExperienceManager\TMA_Request();
$response = $request->module("module-hosting", "/level", $parameters);
if ($response !== FALSE && property_exists($response, "level")) {
	?>
	<div class="exm_level">
		<h3><?php echo $response->level->name; ?></h3>
		<hr style="width: 80%" />
		<p>Monthly requests: <b><?php echo $response->level->monthlyRequests; ?></b> </p>
		<p>Allowed segments: <b><?php echo $response->level->allowedSegments; ?></b> </p>
	</div>
	<div class="exm_level">
		<h3>Current Usage</h3>
		<hr style="width: 80%" />
		<p>Requests this month: <b><?php echo $response->requestCount; ?></b> </p>
		<p>Active segments: <b><?php echo $response->activeSegments; ?></b> </p>
	</div>
	<?php
} else {
	?>
	<div class="exm_level">
		<h3>No level</h3>
		<hr style="width: 80%" />
		<p>We could not find your hosting level!</p>
	</div>
	<?php
}